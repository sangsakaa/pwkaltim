<?php

namespace App\Http\Controllers;

use App\Models\SuratFile;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat = SuratKeluar::latest()->paginate(10);
        return view('administrator.surat.keluar.index', compact('surat'));
    }

    public function show(SuratKeluar $surat)
    {
        return view('administrator.surat.keluar.show', compact('surat'));
    }
    public function edit(SuratKeluar $surat)
    {
        return view('administrator.surat.keluar.edit', compact('surat'));
    }
    public function update(Request $request, SuratKeluar $surat)
    {
        // Validasi sesuai kolom tabel
        $request->validate([
            'nomor_surat'     => 'required|string|max:255',
            'lampiran'        => 'nullable|string|max:255',
            'perihal'         => 'required|string|max:255',
            'kepada'          => 'required|string|max:255',
            'tempat'          => 'nullable|string|max:255',
            'tanggal_hijriah' => 'nullable|string',
            'tanggal_masehi'  => 'nullable|date',
            'isi_surat'       => 'required|string',
            'penandatangan'   => 'nullable|string|max:255',
        ]);

        // Update hanya field yang sudah didefinisikan
        $surat->update($request->only([
            'nomor_surat',
            'lampiran',
            'perihal',
            'kepada',
            'tempat',
            'tanggal_hijriah',
            'tanggal_masehi',
            'isi_surat',
            'penandatangan',
        ]));

        return redirect()
            ->route('surat.index')
            ->with('success', 'Data surat berhasil diperbarui.');
    }



    public function create()
    {
        return view('administrator.surat.keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'perihal' => 'required',
            'kepada' => 'required',
            'isi_surat' => 'required',
        ]);

        SuratKeluar::create($request->all());

        return redirect()->with('success', 'Data surat berhasil disimpan.');
    }
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $surat = SuratKeluar::findOrFail($id);

        // Simpan file ke storage/app/public/surat/
        $path = $request->file('file_surat')->store('surat', 'public');

        // Buat record di surat_files
        SuratFile::create([
            'surat_keluar_id' => $surat->id,
            'nama_file'       => $request->file('file_surat')->getClientOriginalName(),
            'path_file'       => $path,
            'tipe_file'       => $request->file('file_surat')->extension(),
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload!');
    }
    public function downloadFile($fileId)
    {
        $file = SuratFile::findOrFail($fileId);

        if (Storage::disk('public')->exists($file->path_file)) {
            return Storage::disk('public')->download($file->path_file, $file->nama_file);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
    public function viewFile($fileId)
    {
        $file = SuratFile::findOrFail($fileId);

        if (Storage::disk('public')->exists($file->path_file)) {
            $path = Storage::disk('public')->path($file->path_file);
            return response()->file($path); // langsung tampil di browser
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
    public function deleteFile($fileId)
    {
        $file = SuratFile::findOrFail($fileId);

        // Hapus file fisik
        if (Storage::disk('public')->exists($file->path_file)) {
            Storage::disk('public')->delete($file->path_file);
        }

        // Hapus record di database
        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus!');
    }
}
