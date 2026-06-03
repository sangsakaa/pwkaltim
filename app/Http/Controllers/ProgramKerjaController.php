<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreProgramKerjaRequest;
use App\Http\Requests\UpdateProgramKerjaRequest;

class ProgramKerjaController extends Controller
{
    private array $opsiWaktu = ['bulanan', 'triwulan', 'semester', 'tahunan'];

    public function index(Request $request)
    {
        $q = $request->q;
        $tahun = $request->tahun ?? now()->year;
        $waktu = $request->waktu;

        $data = ProgramKerja::query()
            ->when($q, fn($qBuilder) => $qBuilder->search($q))
            ->when($tahun, fn($qBuilder) => $qBuilder->whereYear('created_at', $tahun))
            ->when($waktu && $waktu !== 'semua', fn($qBuilder) => $qBuilder->where('waktu_pelaksanaan', $waktu))
            ->orderBy('nomor')
            ->paginate(10)
            ->withQueryString();

        return view('program-kerja.index', compact('data', 'q', 'tahun', 'waktu'));
    }

    public function create()
    {
        return view('program-kerja.create', [
            'opsiWaktu' => $this->opsiWaktu
        ]);
    }

    public function store(StoreProgramKerjaRequest $request)
    {
        ProgramKerja::create($request->validated());

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    public function show(ProgramKerja $program_kerja)
    {
        return view('program-kerja.show', compact('program_kerja'));
    }

    public function edit(ProgramKerja $program_kerja)
    {
        return view('program-kerja.edit', [
            'program_kerja' => $program_kerja,
            'opsiWaktu' => $this->opsiWaktu
        ]);
    }

    public function update(UpdateProgramKerjaRequest $request, ProgramKerja $program_kerja)
    {
        $program_kerja->update($request->validated());

        return redirect()->back()
            ->with('success', 'Program Kerja berhasil diperbarui.');
    }

    public function destroy(ProgramKerja $program_kerja)
    {
        $program_kerja->delete();

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil dihapus.');
    }

    public function exportPdf(Request $request, $waktu = 'semua')
    {
        $tahun = $request->tahun ?? now()->year;
        $opsi = $this->opsiWaktu;

        if ($waktu !== 'semua' && !in_array($waktu, $opsi)) {
            abort(404);
        }

        $data = ProgramKerja::query()
            ->whereYear('created_at', $tahun)
            ->when(
                $waktu === 'semua',
                fn($q) => $q->whereIn('waktu_pelaksanaan', $opsi),
                fn($q) => $q->where('waktu_pelaksanaan', $waktu)
            )
            ->orderByRaw("FIELD(waktu_pelaksanaan,'bulanan','triwulan','semester','tahunan')")
            ->get();

        $pdf = Pdf::loadView('program-kerja.pdf', [
            'data'  => $data,
            'waktu' => $waktu === 'semua' ? 'Semua Waktu' : ucfirst($waktu),
            'tahun' => $tahun,
        ])->setPaper('F4', 'portrait');

        return $pdf->stream("program-kerja-{$waktu}-{$tahun}.pdf");
    }
}
