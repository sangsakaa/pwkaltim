<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreProgramKerjaRequest;
use App\Http\Requests\UpdateProgramKerjaRequest;

class ProgramKerjaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $data = ProgramKerja::when($q, fn($query) => $query->search($q))
            ->orderBy('nomor')
            ->paginate(10)
            ->withQueryString();

        return view('program-kerja.index', compact('data', 'q'));
    }

    public function create()
    {
        $opsiWaktu = ['bulanan', 'triwulan', 'semester', 'tahunan'];
        return view('program-kerja.create', compact('opsiWaktu'));
    }



    public function show(ProgramKerja $program_kerja)
    {
        return view('program-kerja.show', compact('program_kerja'));
    }

    public function edit(ProgramKerja $program_kerja)
    {
        $opsiWaktu = ['bulanan', 'triwulan', 'semester', 'tahunan'];
        return view('program-kerja.edit', compact('program_kerja', 'opsiWaktu'));
    }
    public function store(StoreProgramKerjaRequest $request)
    {

        ProgramKerja::create($request->validated());
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    public function update(UpdateProgramKerjaRequest $request, ProgramKerja $program_kerja)
    {
        // Update data lama, bukan create baru

        $program_kerja->update($request->validated());

        return redirect()->back()
            ->with('success', 'Program Kerja berhasil diperbarui.');
    }


    public function destroy(ProgramKerja $program_kerja)
    {
        $program_kerja->delete();
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil dihapus.');
    }
    // public function exportPdf($waktu)
    // {
    //     // Validasi input
    //     $opsi = ['bulanan', 'triwulan', 'semester', 'tahunan'];
    //     if (! in_array($waktu, $opsi)) {
    //         abort(404, 'Jenis waktu tidak valid');
    //     }

    //     // Ambil data sesuai waktu
    //     $data = ProgramKerja::where('waktu_pelaksanaan', $waktu)->get();

    //     // Load view PDF
    //     // $pdf = Pdf::loadView('program-kerja.pdf', [
    //     //     'data' => $data,
    //     //     'waktu' => ucfirst($waktu),
    //     // ])->setPaper('A4', 'portrait');
    //     $pdf = Pdf::loadView('program-kerja.pdf', [
    //         'data' => $data,
    //         'waktu' => ucfirst($waktu),
    //     ])
    //         ->setPaper([0, 0, 595.28, 935.43], 'landscape'); // F4 landscape

    //     return $pdf->download("program-kerja-{$waktu}.pdf");
    // }
    public function exportPdf($waktu)
    {
        $opsi = ['bulanan', 'triwulan', 'semester', 'tahunan'];

        if ($waktu !== 'semua' && ! in_array($waktu, $opsi)) {
            abort(404, 'Jenis waktu tidak valid');
        }

        $tahun = now()->year;

        $query = ProgramKerja::query()->whereYear('created_at', $tahun);

        $data = $waktu === 'semua'
            ? $query->whereIn('waktu_pelaksanaan', $opsi)->get()
            : $query->where('waktu_pelaksanaan', $waktu)->get();

        $label = $waktu === 'semua' ? 'Semua Waktu' : ucfirst($waktu);

        $pdf = Pdf::loadView('program-kerja.pdf', [
            'data'  => $data,
            'waktu' => $label,
            'tahun' => $tahun,
            // ])->setPaper([0, 0, 595.28, 935.43], 'landscape');
        ])->setPaper([0, 0, 595.28, 935.43], 'portrait'); // F4 portrait


        $filename = $waktu === 'semua'
            ? "program-kerja-semua-{$tahun}.pdf"
            : "program-kerja-{$waktu}-{$tahun}.pdf";

        // tampilkan di browser, bukan download
        return $pdf->stream($filename);
    }
}
