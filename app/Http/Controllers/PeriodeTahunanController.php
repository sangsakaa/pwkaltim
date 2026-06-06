<?php

namespace App\Http\Controllers;

use App\Models\PeriodeTahunan;
use Illuminate\Http\Request;

class PeriodeTahunanController extends Controller
{
    public function index()
    {
    
    $periodeAktif = PeriodeTahunan::active()->first();    
    $periodes = PeriodeTahunan::latest()->paginate(10);

        return view('periode-tahunan.index', compact('periodes', 'periodeAktif'));
    }

    public function create()
    {
        return view('periode-tahunan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required',
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
        ]);

        PeriodeTahunan::create($request->all());

        return redirect()
            ->route('periode-tahunan.index')
            ->with('success', 'Periode berhasil ditambahkan');
    }

    public function edit(PeriodeTahunan $periodeTahunan)
    {
        return view('periode-tahunan.edit', compact('periodeTahunan'));
    }

    public function update(Request $request, PeriodeTahunan $periodeTahunan)
    {
        $request->validate([
            'nama_periode' => 'required',
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
        ]);

        $periodeTahunan->update($request->all());

        return redirect()
            ->route('periode-tahunan.index')
            ->with('success', 'Periode berhasil diperbarui');
    }

    public function destroy(PeriodeTahunan $periodeTahunan)
    {
        $periodeTahunan->delete();

        return back()->with('success', 'Periode berhasil dihapus');
    }

    /**
     * Aktifkan periode
     */
    public function activate($id)
    {
        PeriodeTahunan::query()->update([
            'is_active' => false
        ]);

        PeriodeTahunan::findOrFail($id)
            ->update([
                'is_active' => true
            ]);

        return back()->with(
            'success',
            'Periode berhasil diaktifkan'
        );
    }

    /**
     * Akhiri periode
     */
    public function finish($id)
    {
        PeriodeTahunan::findOrFail($id)
            ->update([
                'is_active' => false,
                'tanggal_selesai' => now(),
            ]);

        return back()->with(
            'success',
            'Periode berhasil diakhiri'
        );
    }
    public function generate()
    {
        $tahun = now()->year;

        $exists = PeriodeTahunan::where('tahun_mulai', $tahun)
            ->where('tahun_selesai', $tahun)
            ->exists();

        if ($exists) {
            return back()->with(
                'warning',
                "Periode tahun {$tahun} sudah tersedia."
            );
        }

        PeriodeTahunan::create([
            'nama_periode'     => "Program Kerja {$tahun}",
            'tahun_mulai'      => $tahun,
            'tahun_selesai'    => $tahun,
            'tanggal_mulai'    => "{$tahun}-01-01",
            'tanggal_selesai'  => "{$tahun}-12-31",
            'is_active'        => false,
            'keterangan'       => "Periode program kerja tahun {$tahun}",
        ]);

        return redirect()
            ->route('periode-tahunan.index')
            ->with(
                'success',
                "Periode tahun {$tahun} berhasil dibuat."
            );
    }
}
