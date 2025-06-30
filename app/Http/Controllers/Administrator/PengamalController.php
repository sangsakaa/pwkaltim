<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Pengamal;
use Illuminate\Http\Request;
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
        return view('administrator/pengamal/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:pengamal,nik',
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
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

        $pengamal = Pengamal::create($validated);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        ]);

        $pengamal->update($validated);

        return response()->json($pengamal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
