<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratTugasController extends Controller
{
    public function index()
    {
        $surat = SuratTugas::latest()->paginate(10);
        return view('administrator.surat.tugas.index', compact('surat'));
    }

    public function create()
    {
        return view('administrator.surat.tugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|unique:surat_tugas',
            'nama' => 'required',
            'hari' => 'required',
            'tanggal_masehi' => 'required|date',
            'pukul' => 'required',
            'tempat' => 'required',
            'alamat' => 'required',
            'keperluan' => 'required',
            'kota' => 'required',
            'tanggal_surat_masehi' => 'required|date',
            'penandatangan' => 'required',
        ]);

        SuratTugas::create($request->all());
        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil ditambahkan.');
    }

    public function show(SuratTugas $surat_tuga)
    {
        return view('administrator.surat.tugas.show', compact('surat_tuga'));
    }

    public function edit(SuratTugas $surat_tuga)
    {
        return view('administrator.surat.tugas.edit', compact('surat_tuga'));
    }

    public function update(Request $request, SuratTugas $surat_tuga)
    {
        $request->validate([
            'nama' => 'required',
            'hari' => 'required',
            'tanggal_masehi' => 'required|date',
            'pukul' => 'required',
            'tempat' => 'required',
            'alamat' => 'required',
            'keperluan' => 'required',
            'kota' => 'required',
            'tanggal_surat_masehi' => 'required|date',
            'penandatangan' => 'required',
        ]);

        $surat_tuga->update($request->all());
        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil diperbarui.');
    }

    public function destroy(SuratTugas $surat_tuga)
    {
        $surat_tuga->delete();
        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dihapus.');
    }

    public function cetakPdf($id)
    {
        $surat = SuratTugas::findOrFail($id);

        // Sanitasi nomor surat agar bisa jadi nama file
        $safeNomor = str_replace(['/', '\\'], '-', $surat->nomor);

        $pdf = Pdf::loadView('administrator.surat.tugas.pdf', compact('surat'))
            ->setPaper('A4');

        return $pdf->stream("surat_tugas_{$safeNomor}.pdf");
    }
}
