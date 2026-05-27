<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\{District, Pengamal, Province, Regency, Village};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengamalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole([
                'admin-provinsi',
                'admin-kabupaten',
                'admin-kecamatan',
                'admin-desa',
                'superAdmin'
            ]),
            403
        );

        $dataPengamal = Pengamal::query()
            ->with(Pengamal::relations())
            ->byUserRole($user)
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | CHART
        |--------------------------------------------------------------------------
        */
        $chartConfig = match (true) {
            $user->hasRole('admin-provinsi') => [
                'label' => 'regencies.name',
                'key'   => 'pengamal.kabupaten',
            ],

            $user->hasRole('admin-kabupaten') => [
                'label' => 'districts.name',
                'key'   => 'pengamal.kecamatan',
            ],

            default => [
                'label' => 'villages.name',
                'key'   => 'pengamal.desa',
            ],
        };

        $chartKabupaten = DB::table('pengamal')
            ->leftJoin(
                'regencies',
                'regencies.code',
                '=',
                'pengamal.kabupaten'
            )
            ->leftJoin(
                'districts',
                'districts.code',
                '=',
                'pengamal.kecamatan'
            )
            ->leftJoin(
                'villages',
                'villages.code',
                '=',
                'pengamal.desa'
            )
            ->select(
            $chartConfig['key'],
            DB::raw($chartConfig['label'] . ' as label'),
            DB::raw('COUNT(*) as total')
            )
            ->when(
                $user->hasRole('admin-provinsi'),
                fn($q) => $q->where(
                    'pengamal.provinsi',
                    $user->code
                )
            )
            ->when(
                $user->hasRole('admin-kabupaten'),
                fn($q) => $q->where(
                    'pengamal.kabupaten',
                    $user->code
                )
            )
            ->when(
                $user->hasRole('admin-kecamatan'),
                fn($q) => $q->where(
                    'pengamal.kecamatan',
                    $user->code
                )
            )
            ->when(
                $user->hasRole('admin-desa'),
                fn($q) => $q->where(
                    'pengamal.desa',
                    $user->code
                )
            )
            ->groupBy(
                $chartConfig['key'],
                'label'
            )
            ->get();

        return view('administrator.pengamal.index', [
            'dataPengamal'   => $dataPengamal,
            'chartKabupaten' => $chartKabupaten,
            'chartTitle'     => $this->getChartTitle($user),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Pengamal $pengamal)
    {
        $this->authorizePengamal($pengamal);

        $pengamal->load(Pengamal::relations());

        return view(
            'administrator.pengamal.show',
            compact('pengamal')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return $this->formView(false);
    }

    public function createPublic()
    {
        return $this->formView(true);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $this->validatePengamal($request);

        $validated['foto'] =
            $request->hasFile('foto')
            ? $request->file('foto')
            ->store('foto/pengamal', 'public')
            : null;

        Pengamal::create($this->mapPengamalData($validated));

        if (!auth()->check()) {
            return back()->with(
                'success',
                'Data pengamal berhasil dikirim.'
            );
        }

        return redirect()
            ->route('pengamal.index')
            ->with(
                'success',
                'Pengamal berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Pengamal $pengamal)
    {
        $this->authorizePengamal($pengamal);

        return view(
            'administrator.pengamal.edit',
            [
                'pengamal'   => $pengamal,
                'provinces'  => Province::where('code', 64)->get(),
                'regencies'  => Regency::where(
                    'province_code',
                    $pengamal->provinsi
                )->get(),
                'districts'  => District::where(
                    'regency_code',
                    $pengamal->kabupaten
                )->get(),
                'villages'   => Village::where(
                    'district_code',
                    $pengamal->kecamatan
                )->get(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Pengamal $pengamal)
    {
        $this->authorizePengamal($pengamal);

        $validated = $this->validatePengamal(
            $request,
            $pengamal->id
        );

        $foto = $pengamal->foto;

        if ($request->hasFile('foto')) {
            if (
                $foto &&
                Storage::disk('public')->exists($foto)
            ) {
                Storage::disk('public')
                    ->delete($foto);
            }

            $foto = $request->file('foto')
                ->store(
                    'foto/pengamal',
                    'public'
                );
        }

        $validated['foto'] = $foto;

        $pengamal->update(
            $this->mapPengamalData($validated)
        );

        return redirect()
            ->route('pengamal.index')
            ->with(
                'success',
                'Pengamal berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Pengamal $pengamal)
    {
        $this->authorizePengamal($pengamal);

        $pengamal->delete();

        return redirect()
            ->route('pengamal.index')
            ->with(
                'error',
                'Data pengamal berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */
    public function getRegencies($province_code)
    {
        return Regency::where(
            'province_code',
            $province_code
        )->get();
    }

    public function getDistricts($regency_code)
    {
        return District::where(
            'regency_code',
            $regency_code
        )->get();
    }

    public function getVillages($district_code)
    {
        return Village::where(
            'district_code',
            $district_code
        )->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    private function formView(bool $isPublic)
    {
        return view(
            'administrator.pengamal.create',
            [
                'provinces' =>
                Province::where('code', 64)->get(),
                'isPublic' => $isPublic,
            ]
        );
    }

    private function authorizePengamal(
        Pengamal $pengamal
    ): void {
        $user = auth()->user();

        abort_if(
            $user->hasRole('admin-provinsi')
                && $pengamal->provinsi != $user->code,
            403
        );

        abort_if(
            $user->hasRole('admin-kabupaten')
                && $pengamal->kabupaten != $user->code,
            403
        );

        abort_if(
            $user->hasRole('admin-kecamatan')
                && $pengamal->kecamatan != $user->code,
            403
        );

        abort_if(
            $user->hasRole('admin-desa')
                && $pengamal->desa != $user->code,
            403
        );
    }

    private function validatePengamal(
        Request $request,
        ?int $id = null
    ): array {
        return $request->validate([
            'nik' => [
                'nullable',
                'digits:16',
                Rule::unique(
                    'pengamal',
                    'nik'
                )->ignore($id)
            ],

            'nama_lengkap' =>
            'required|string|max:255',

            'tanggal_lahir' =>
            'nullable|date',

            'tempat_lahir' =>
            'nullable|string|max:100',

            'jenis_kelamin' =>
            'nullable|in:L,P',

            'agama' =>
            'nullable|string|max:50',

            'province_code' =>
            'required|string',

            'regency_code' =>
            'required|string',

            'district_code' =>
            'required|string',

            'village_code' =>
            'required|string',

            'alamat' =>
            'nullable|string|max:500',

            'no_hp' =>
            'nullable|string|max:20',

            'email' =>
            'nullable|email|max:255',

            'rt' =>
            'nullable|string|max:5',

            'rw' =>
            'nullable|string|max:5',

            'foto' =>
            'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'pekerjaan' =>
            'nullable|string|max:100',

            'status_perkawinan' =>
            'nullable|string|max:100',
        ]);
    }

    private function mapPengamalData(
        array $validated
    ): array {
        return [
            'nik' => $validated['nik'] ?? null,
            'nama_lengkap' => $validated['nama_lengkap'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'agama' => $validated['agama'] ?? null,

            'provinsi' => $validated['province_code'],
            'kabupaten' => $validated['regency_code'],
            'kecamatan' => $validated['district_code'],
            'desa' => $validated['village_code'],

            'alamat' => $validated['alamat'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'email' => $validated['email'] ?? null,
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,

            'foto' => $validated['foto'] ?? null,

            'pekerjaan' =>
            $validated['pekerjaan'] ?? null,

            'status_perkawinan' =>
            $validated['status_perkawinan'] ?? null,
        ];
    }

    private function getChartTitle($user)
    {
        return match (true) {
            $user->hasRole('admin-provinsi')
            => 'Grafik Pengamal per Kabupaten',

            $user->hasRole('admin-kabupaten')
            => 'Grafik Pengamal per Kecamatan',

            default
            => 'Grafik Pengamal per Desa',
        };
    }
    public function sync()
    {
        try {

            $response = Http::timeout(60)
                ->get(
                    'https://pendataan.ypwkalimantantimur.my.id/api/pengamal'
                );

            if (!$response->successful()) {
                return back()->with(
                    'error',
                    'Gagal mengambil data API.'
                );
            }

            $items = $response->json();

            $total = 0;

            foreach ($items as $item) {

                Pengamal::updateOrCreate(
                    [
                        'nik' => $item['nik']
                    ],
                    [
                        'nama_lengkap' => $item['nama_lengkap'],
                        'tanggal_lahir' => $item['tanggal_lahir'],
                        'tempat_lahir' => $item['tempat_lahir'],
                        'jenis_kelamin' => $item['jenis_kelamin'],
                        'agama' => $item['agama'],

                        'provinsi' => $item['provinsi'],
                        'kabupaten' => $item['kabupaten'],
                        'kecamatan' => $item['kecamatan'],
                        'desa' => $item['desa'],

                        'alamat' => $item['alamat'],
                        'rt' => $item['rt'],
                        'rw' => $item['rw'],

                        'no_hp' => $item['no_hp'],
                        'email' => $item['email'],

                        'pekerjaan' => $item['pekerjaan'],
                        'status_perkawinan'
                        => $item['status_perkawinan'],

                        'foto' => $item['foto'],
                    ]
                );

                $total++;
            }

            return back()->with(
                'success',
                "Sinkron berhasil ({$total} data)."
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal sinkron: ' . $e->getMessage()
            );
        }
    }
}
