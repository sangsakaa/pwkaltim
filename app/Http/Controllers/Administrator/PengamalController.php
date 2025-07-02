<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PengamalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPengamal = Pengamal::all();
        return view('administrator/pengamal/index',compact('dataPengamal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
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
        return view('administrator/pengamal/edit', compact('pengamal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengamal $pengamal)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:pengamal,nik,' . $pengamal->id,
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
            // 'status_perkawinan' => 'nullable|string',
            // 'pekerjaan' => 'nullable|string',
            // 'kewarganegaraan' => 'nullable|string',
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
        ]);

        $pengamal->update($validated);

        // return response()->json($pengamal);
        return redirect()->back()->with('success', 'Pengamal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengamal $pengamal)
    {
        $pengamal->delete();
        return redirect()->route('pengamal.index')->with('success', 'Pengamal deleted successfully');
        // return response()->json(['message' => 'Pengamal deleted successfully']);
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
