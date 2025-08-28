<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index()
    {
        $surat = SuratMasuk::latest()->paginate(10);
        return view('administrator.surat.masuk.index', compact('surat'));
    }

    public function create()
    {
        return view('administrator.surat.masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|unique:surat_masuk',
            'asal_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'file_surat' => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('surat_masuk', 'public');
        }

        SuratMasuk::create([
            'nomor_surat' => $request->nomor_surat,
            'asal_surat' => $request->asal_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_surat' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('administrator.surat.masuk.show', compact('surat'));
    }

    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('administrator.surat.masuk.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|unique:surat_masuk,nomor_surat,' . $surat->id,
            'asal_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'file_surat' => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

        $filePath = $surat->file_surat;
        if ($request->hasFile('file_surat')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file_surat')->store('surat_masuk', 'public');
        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'asal_surat' => $request->asal_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_surat' => $filePath,
        ]);

        return redirect()->route('administrator.masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        $surat->delete();

        return redirect()->back()->with('success', 'Surat masuk berhasil dihapus.');
    }
}
