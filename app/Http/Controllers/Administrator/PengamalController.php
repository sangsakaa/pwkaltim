<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PengamalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();


        // Gunakan query builder dari awal
        $query = Pengamal::query()->orderby('kecamatan', 'asc');

        // Filter berdasarkan role
        if ($user->hasRole('admin-kabupaten')) {
            $query->where('kabupaten', $user->code);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $query->where('kecamatan', $user->code);
        } elseif ($user->hasRole('admin-desa')) {
            $query->where('desa', $user->code);
        }

        // Filter pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan pagination dan simpan query search di URL
        $dataPengamal = $query->paginate(10)->withQueryString();

        return view('administrator.pengamal.index', compact('dataPengamal'));
    }

    public function create()
    {
        $provinces = Province::where('code', 64)->get(); // Ambil semua provinsi kecuali yang kode 00
        return view('administrator/pengamal/create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        // dd($request->all());
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:pengamal,nik',
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
            'province_code' => 'required|string',
            'regency_code' => 'required|string',
            'district_code' => 'required|string',
            'village_code' => 'required|string',
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
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto/pengamal', 'public');
        }

        $data = [
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
        ];

        Pengamal::create($data);


        return redirect()->back()->with('success', 'Pengamal created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengamal $pengamal)
    {
        $pengamal = Pengamal::with(['province', 'regency', 'district', 'village'])->find($pengamal->id);

        // akses nama wilayah:


        return view('administrator/pengamal/show', compact('pengamal'));
    }

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
