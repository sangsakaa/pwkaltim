<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengamalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole([
            'admin-provinsi',
            'admin-kabupaten',
            'admin-kecamatan',
            'admin-desa',
            'superAdmin'
        ])) {
            abort(403, 'Unauthorized');
        }

        /*
    |--------------------------------------------------------------------------
    | BASE QUERY (TABLE)
    |--------------------------------------------------------------------------
    */
        $query = Pengamal::query()
            ->with(['province', 'regency', 'district', 'village']);

        /*
    |--------------------------------------------------------------------------
    | ROLE FILTER (TABLE)
    |--------------------------------------------------------------------------
    */
        $query->when(
            $user->hasRole('admin-provinsi'),
            fn($q) =>
            $q->where('provinsi', $user->code)
        );

        $query->when(
            $user->hasRole('admin-kabupaten'),
            fn($q) =>
            $q->where('kabupaten', $user->code)
        );

        $query->when(
            $user->hasRole('admin-kecamatan'),
            fn($q) =>
            $q->where('kecamatan', $user->code)
        );

        $query->when(
            $user->hasRole('admin-desa'),
            fn($q) =>
            $q->where('desa', $user->code)
        );

        /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($sub) use ($search) {
                $sub->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        });

        $dataPengamal = $query->latest()
            ->paginate(10)
            ->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | CHART ROLE LOGIC
    |--------------------------------------------------------------------------
    | kecamatan => tampil desa di kecamatan itu saja
    |--------------------------------------------------------------------------
    */
        $groupColumn = match (true) {
            $user->hasRole('admin-provinsi')  => 'regencies.name',
            $user->hasRole('admin-kabupaten') => 'districts.name',
            $user->hasRole('admin-kecamatan') => 'villages.name',
            $user->hasRole('admin-desa')      => 'villages.name',
            default                            => 'regencies.name',
        };

        $groupKey = match (true) {
            $user->hasRole('admin-provinsi')  => 'pengamal.kabupaten',
            $user->hasRole('admin-kabupaten') => 'pengamal.kecamatan',
            $user->hasRole('admin-kecamatan') => 'pengamal.desa',
            $user->hasRole('admin-desa')      => 'pengamal.desa',
            default                            => 'pengamal.kabupaten',
        };

        /*
    |--------------------------------------------------------------------------
    | CHART QUERY (IMPORTANT FIX: APPLY ROLE FILTER HERE TOO)
    |--------------------------------------------------------------------------
    */
        $chartQuery = DB::table('pengamal')
            ->leftJoin('regencies', 'regencies.code', '=', 'pengamal.kabupaten')
            ->leftJoin('districts', 'districts.code', '=', 'pengamal.kecamatan')
            ->leftJoin('villages', 'villages.code', '=', 'pengamal.desa')
            ->select(
            $groupKey,
            DB::raw("$groupColumn as label"),
            DB::raw('COUNT(*) as total')
            );

        // 🔥 APPLY SAME ROLE FILTER (INI YANG KURANG SEBELUMNYA)
        $chartQuery->when(
            $user->hasRole('admin-provinsi'),
            fn($q) =>
            $q->where('pengamal.provinsi', $user->code)
        );

        $chartQuery->when(
            $user->hasRole('admin-kabupaten'),
            fn($q) =>
            $q->where('pengamal.kabupaten', $user->code)
        );

        $chartQuery->when(
            $user->hasRole('admin-kecamatan'),
            fn($q) =>
            $q->where('pengamal.kecamatan', $user->code)
        );

        $chartQuery->when(
            $user->hasRole('admin-desa'),
            fn($q) =>
            $q->where('pengamal.desa', $user->code)
        );

        $chartData = $chartQuery
            ->groupBy($groupKey, 'label')
            ->get();

        return view('administrator.pengamal.index', [
            'dataPengamal'   => $dataPengamal,
            'chartKabupaten' => $chartData,
            'chartTitle'     => $this->getChartTitle($user),
        ]);
    }

    /*
|--------------------------------------------------------------------------
| OPTIONAL: helper judul chart
|--------------------------------------------------------------------------
*/
    private function getChartTitle($user)
    {
        return match (true) {
            $user->hasRole('admin-provinsi')  => 'Grafik Pengamal per Kabupaten',
            $user->hasRole('admin-kabupaten') => 'Grafik Pengamal per Kecamatan',
            $user->hasRole('admin-kecamatan') => 'Grafik Pengamal per Desa',
            $user->hasRole('admin-desa')      => 'Grafik Pengamal per Desa',
            default                            => 'Grafik Pengamal',
        };
    }
    public function show(Pengamal $pengamal)
    {
        $user = Auth::user();

        // 🔒 CHECK ROLE
        if (!$user->hasAnyRole(['admin-provinsi', 'admin-kabupaten', 'admin-kecamatan', 'admin-desa', 'superAdmin'])) {
            abort(403, 'Unauthorized');
        }

        // 🔐 FILTER WILAYAH (biar tidak bisa buka data luar wilayah)
        if ($user->hasRole('admin-provinsi') && $pengamal->provinsi != $user->code) {
            abort(403);
        }

        if ($user->hasRole('admin-kabupaten') && $pengamal->kabupaten != $user->code) {
            abort(403);
        }

        if ($user->hasRole('admin-kecamatan') && $pengamal->kecamatan != $user->code) {
            abort(403);
        }

        if ($user->hasRole('admin-desa') && $pengamal->desa != $user->code) {
            abort(403);
        }

        // 🔥 LOAD RELASI DETAIL
        $pengamal->load(['province', 'regency', 'district', 'village']);

        return view('administrator.pengamal.show', compact('pengamal'));
    }

    public function create()
    {
        $provinces = Province::where('code', 64)->get();

        return view('administrator.pengamal.create', [
            'provinces' => $provinces,
            'isPublic' => false,
        ]);
    }

    public function createPublic()
    {
        $provinces = Province::where('code', 64)->get();

        return view('administrator.pengamal.create', [
            'provinces' => $provinces,
            'isPublic' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // DATA PRIBADI
            'nik' => 'nullable|digits:16|unique:pengamal,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:50',

            // WILAYAH (WAJIB)
            'province_code' => 'required|string',
            'regency_code' => 'required|string',
            'district_code' => 'required|string',
            'village_code' => 'required|string',

            // KONTAK
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',

            // FILE
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // TAMBAHAN
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'nullable|string|max:100',

        ], [

            // NIK
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',

            // REQUIRED
            'nama_lengkap.required' =>
            'Nama lengkap wajib diisi.',

            'province_code.required' =>
            'Provinsi wajib dipilih.',

            'regency_code.required' =>
            'Kabupaten/Kota wajib dipilih.',

            'district_code.required' =>
            'Kecamatan wajib dipilih.',

            'village_code.required' =>
            'Desa/Kelurahan wajib dipilih.',

            // FORMAT
            'tanggal_lahir.date' =>
            'Tanggal lahir tidak valid.',

            'jenis_kelamin.in' =>
            'Jenis kelamin harus L atau P.',

            'email.email' =>
            'Format email tidak valid.',

            // FOTO
            'foto.image' =>
            'File harus berupa gambar.',

            'foto.mimes' =>
            'Foto harus JPG, JPEG, atau PNG.',

            'foto.max' =>
            'Ukuran foto maksimal 2MB.',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Upload Foto
    |--------------------------------------------------------------------------
    */
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->store('foto/pengamal', 'public');
        }

        /*
    |--------------------------------------------------------------------------
    | Simpan Data
    |--------------------------------------------------------------------------
    */
        Pengamal::create([
            'nik' => $validated['nik'] ?? null,
            'nama_lengkap' => $validated['nama_lengkap'],

            'tanggal_lahir' =>
            $validated['tanggal_lahir'] ?? null,

            'tempat_lahir' =>
            $validated['tempat_lahir'] ?? null,

            'jenis_kelamin' =>
            $validated['jenis_kelamin'] ?? null,

            'agama' =>
            $validated['agama'] ?? null,

            'provinsi' =>
            $validated['province_code'],

            'kabupaten' =>
            $validated['regency_code'],

            'kecamatan' =>
            $validated['district_code'],

            'desa' =>
            $validated['village_code'],

            'alamat' =>
            $validated['alamat'] ?? null,

            'no_hp' =>
            $validated['no_hp'] ?? null,

            'email' =>
            $validated['email'] ?? null,

            'rt' =>
            $validated['rt'] ?? null,

            'rw' =>
            $validated['rw'] ?? null,

            'foto' => $fotoPath,

            'pekerjaan' =>
            $validated['pekerjaan'] ?? null,

            'status_perkawinan' =>
            $validated['status_perkawinan'] ?? null,
        ]);

        /*
    |--------------------------------------------------------------------------
    | MODE PUBLIC
    |--------------------------------------------------------------------------
    */
        if (!auth()->check()) {
            return back()->with(
                'success',
                'Data pengamal berhasil dikirim.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | CALLBACK ROLE
    |--------------------------------------------------------------------------
    */
        $user = auth()->user();

        if ($user->hasRole('admin-provinsi')) {
            return redirect()
                ->route('pengamal.index')
                ->with(
                    'success',
                    'Pengamal berhasil ditambahkan.'
                );
        }

        if ($user->hasRole('admin-kabupaten')) {
            return redirect('/dashboard')
                ->with(
                    'success',
                    'Pengamal berhasil ditambahkan.'
                );
        }

        if (
            $user->hasRole('admin-kecamatan') ||
            $user->hasRole('admin-desa')
        ) {
            return redirect()
                ->route('pengamal.index')
                ->with(
                    'success',
                    'Pengamal berhasil ditambahkan.'
                );
        }

        return back()->with(
            'success',
            'Pengamal berhasil ditambahkan.'
        );
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengamal $pengamal)
    {
        // $provinces = Province::all();
        $provinces = Province::where('code', 64)->get(); // Ambil semua provinsi kecuali yang kode 00
        return view('administrator/pengamal/edit', compact('pengamal', 'provinces'))->with('success', 'Pengamal berhasil diperbarui.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Ambil data pengamal berdasarkan ID
        // dd($request->all());
        $pengamal = Pengamal::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('pengamal', 'nik')->ignore($pengamal->id),
            ],
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
            'province_code' => 'required|string',
            'regency_code' => 'required|string',
            'district_code' => 'required|string',
            'village_code' => 'required|string|filled',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'nullable|email',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'agama.string' => 'Agama harus berupa teks.',
            'province_code.required' => 'Provinsi wajib dipilih.',
            'regency_code.required' => 'Kabupaten/Kota wajib dipilih.',
            'district_code.required' => 'Kecamatan wajib dipilih.',
            'village_code.required' => 'Desa/Kelurahan wajib dipilih.',
            'village_code.filled'   => 'Kode desa tidak boleh kosong.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Proses foto jika diunggah
        $fotoPath = $pengamal->foto; // default tetap pakai foto lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pengamal->foto && Storage::disk('public')->exists($pengamal->foto)) {
                Storage::disk('public')->delete($pengamal->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('foto/pengamal', 'public');
        }

        // Update data pengamal
        $pengamal->update([
            'nik' => $validated['nik'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'agama' => $validated['agama'] ?? null,
            'provinsi' => $validated['province_code'],
            'kabupaten' => $validated['regency_code'],
            'kecamatan' => $validated['district_code'],
            'desa' => $validated['village_code'],
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'foto' => $fotoPath,
            'email' => $validated['email'] ?? null,
            'pekerjaan' => $validated['pekerjaan'] ?? null,
            'status_perkawinan' => $validated['status_perkawinan'] ?? null,
        ]);

        // Redirect dengan notifikasi sukses
        return redirect()->back()->with('success', 'Pengamal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengamal $pengamal)
    {
        $pengamal->delete(); // Ini otomatis jadi soft delete jika model pakai SoftDeletes
        // toastr()->error('An error has occurred please try again later.');

        return redirect()->route('pengamal.index')->with('error', 'Data pengamal berhasil dihapus.');
    }




    // ajax methods for dynamic dropdowns


    public function getRegencies($province_code)
    {
        return Regency::where('province_code', $province_code)->get();
    }

    public function getDistricts($regency_code)
    {
        return District::where('regency_code', $regency_code)->get();
    }

    public function getVillages($district_code)
    {
        return Village::where('district_code', $district_code)->get();
    }
}
