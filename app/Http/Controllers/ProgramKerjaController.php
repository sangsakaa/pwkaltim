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
        $q = $request->get('q');

        $data = ProgramKerja::when($q, function ($query) use ($q) {
            $query->search($q);
        })
            ->orderBy('nomor')
            ->paginate(10)
            ->withQueryString();

        return view('program-kerja.index', compact('data', 'q'));
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

        return redirect()
            ->route('program-kerja.index')
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

        return redirect()
            ->back()
            ->with('success', 'Program Kerja berhasil diperbarui.');
    }

    public function destroy(ProgramKerja $program_kerja)
    {
        $program_kerja->delete();

        return redirect()
            ->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil dihapus.');
    }

    /**
     * FIXED EXPORT PDF
     * - aman jika tanpa parameter
     * - support: semua / bulanan / triwulan / semester / tahunan
     */
    public function exportPdf($waktu = 'semua')
    {
        $waktu = strtolower($waktu);

        $tahun = now()->year;

        // validasi
        if ($waktu !== 'semua' && !in_array($waktu, $this->opsiWaktu)) {
            abort(404, 'Jenis waktu tidak valid');
        }

        $query = ProgramKerja::query()
            ->whereYear('created_at', $tahun)
            ->orderByRaw("
                FIELD(waktu_pelaksanaan, 'bulanan', 'triwulan', 'semester', 'tahunan')
            ");

        // filter data
        if ($waktu === 'semua') {
            $data = $query->whereIn('waktu_pelaksanaan', $this->opsiWaktu)->get();
        } else {
            $data = $query->where('waktu_pelaksanaan', $waktu)->get();
        }

        $label = $waktu === 'semua'
            ? 'Semua Waktu'
            : ucfirst($waktu);

        $pdf = Pdf::loadView('program-kerja.pdf', [
            'data'  => $data,
            'waktu' => $label,
            'tahun' => $tahun,
        ])
            ->setPaper('F4', 'portrait');

        $filename = $waktu === 'semua'
            ? "program-kerja-semua-{$tahun}.pdf"
            : "program-kerja-{$waktu}-{$tahun}.pdf";

        return $pdf->stream($filename);
    }
}
