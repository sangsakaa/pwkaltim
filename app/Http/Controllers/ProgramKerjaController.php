<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramKerjaRequest;
use App\Http\Requests\UpdateProgramKerjaRequest;
use App\Http\Requests\UpdateRealisasiProgramKerjaRequest;
use App\Models\PeriodeTahunan;
use App\Models\ProgramKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramKerjaController extends Controller
{
    private array $opsiWaktu = [
        'bulanan',
        'triwulan',
        'semester',
        'tahunan'
    ];

    // ==================================================
    // PROGRAM KERJA
    // ==================================================

    public function index(Request $request)
    {
        $waktu = $request->input('waktu', 'semua');

        $periodeAktif = PeriodeTahunan::where('is_active', true)->first();

        $data = ProgramKerja::with('periodeTahunan')
            ->when(
                $request->filled('q'),
                fn($query) => $query->search($request->q)
            )
            ->when(
                $periodeAktif,
                fn($query) => $query->where(
                    'periode_tahunan_id',
                    $periodeAktif->id
                )
            )
            ->when(
                $waktu !== 'semua',
                fn($query) => $query->where(
                    'waktu_pelaksanaan',
                    $waktu
                )
            )
            ->orderBy('nomor')
            ->paginate(10)
            ->withQueryString();

        return view('program-kerja.index', [
            'data'          => $data,
            'waktu'         => $waktu,
            'periodeAktif'  => $periodeAktif,
        ]);
    }

    public function create()
    {
        $periodeAktif = PeriodeTahunan::where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()
                ->route('periode-tahunan.index')
                ->with(
                    'error',
                    'Belum ada periode tahunan yang aktif.'
                );
        }

        return view('program-kerja.create', [
            'opsiWaktu'    => $this->opsiWaktu,
            'periodeAktif' => $periodeAktif,
        ]);
    }

    public function store(StoreProgramKerjaRequest $request)
    {
        $periodeAktif = PeriodeTahunan::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with(
                'error',
                'Belum ada periode aktif.'
            );
        }

        ProgramKerja::create([
            ...$request->validated(),
            'periode_tahunan_id' => $periodeAktif->id,
        ]);

        return redirect()
            ->route('program-kerja.index')
            ->with(
                'success',
                'Program Kerja berhasil ditambahkan.'
            );
    }

    public function show(ProgramKerja $program_kerja)
    {
        return view(
            'program-kerja.show',
            compact('program_kerja')
        );
    }

    public function edit(ProgramKerja $program_kerja)
    {
        return view('program-kerja.edit', [
            'program_kerja' => $program_kerja,
            'opsiWaktu'     => $this->opsiWaktu,
        ]);
    }

    public function update(
        UpdateProgramKerjaRequest $request,
        ProgramKerja $program_kerja
    ) {
        $program_kerja->update(
            $request->validated()
        );

        return redirect()
            ->route('program-kerja.index')
            ->with(
                'success',
                'Program Kerja berhasil diperbarui.'
            );
    }

    public function destroy(ProgramKerja $program_kerja)
    {
        $program_kerja->delete();

        return redirect()
            ->route('program-kerja.index')
            ->with(
                'success',
                'Program Kerja berhasil dihapus.'
            );
    }

    // ==================================================
    // EXPORT PDF
    // ==================================================

    public function exportPdf(
        Request $request,
        $waktu = 'semua'
    ) {
        $periodeId = $request->periode;

        if (
            $waktu !== 'semua' &&
            !in_array($waktu, $this->opsiWaktu)
        ) {
            abort(404);
        }

        $periode = PeriodeTahunan::find($periodeId);

        $data = ProgramKerja::query()
            ->when(
                $periodeId,
                fn($query) =>
                $query->where(
                    'periode_tahunan_id',
                    $periodeId
                )
            )
            ->when(
                $waktu === 'semua',
                fn($query) =>
                $query->whereIn(
                    'waktu_pelaksanaan',
                    $this->opsiWaktu
                ),
                fn($query) =>
                $query->where(
                    'waktu_pelaksanaan',
                    $waktu
                )
            )
            ->orderByRaw("
                FIELD(
                    waktu_pelaksanaan,
                    'bulanan',
                    'triwulan',
                    'semester',
                    'tahunan'
                )
            ")
            ->get();

        $pdf = Pdf::loadView(
            'program-kerja.pdf',
            [
                'data'    => $data,
                'periode' => $periode,
                'waktu'   => $waktu === 'semua'
                    ? 'Semua Waktu'
                    : ucfirst($waktu),
            ]
        )->setPaper('F4', 'portrait');

        return $pdf->stream(
            'program-kerja.pdf'
        );
    }

    // ==================================================
    // REALISASI
    // ==================================================

    public function realisasiIndex(Request $request)
    {
        $periodeAktif = PeriodeTahunan::where('is_active', true)->first();

        $data = ProgramKerja::with('periodeTahunan')
            ->when(
                $periodeAktif,
                fn($query) =>
                $query->where(
                    'periode_tahunan_id',
                    $periodeAktif->id
                )
            )
            ->latest()
            ->paginate(15);

        return view(
            'program-kerja.realisasi.index',
            compact(
                'data',
                'periodeAktif'
            )
        );
    }
    public function realisasiEdit(
        ProgramKerja $program_kerja
    ) {
        return view(
            'program-kerja.realisasi.edit',
            compact('program_kerja')
        );
    }

    public function realisasiUpdate(
        UpdateRealisasiProgramKerjaRequest $request,
        ProgramKerja $program_kerja
    ) {
        $validated = $request->validated();

        $validated['status_realisasi'] = $this->autoStatusByProgress(
            (int) ($validated['progress'] ?? 0)
        );

        if (($validated['progress'] ?? 0) == 100 && empty($validated['tanggal_selesai'])) {
            $validated['tanggal_selesai'] = now()->toDateString();
        }

        $program_kerja->update($validated);

        return redirect()
            ->route('program-kerja.realisasi.index')
            ->with('success', 'Realisasi berhasil diperbarui.');
    }



    // ==================================================
    // HELPER
    // ==================================================

    private function autoStatusByProgress(
        int $progress
    ): string {
        if ($progress <= 30) {
            return 'belum';
        }

        if ($progress <= 70) {
            return 'proses';
        }

        return 'selesai';
    }
    public function transferPeriodeSebelumnya()
    {
        $periodeAktif = PeriodeTahunan::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with(
                'error',
                'Belum ada periode aktif.'
            );
        }

        $periodeSebelumnya = PeriodeTahunan::where(
            'id',
            '<>',
            $periodeAktif->id
        )
            ->orderByDesc('tahun_selesai')
            ->first();

        if (!$periodeSebelumnya) {
            return back()->with(
                'error',
                'Periode sebelumnya tidak ditemukan.'
            );
        }

        $programLama = ProgramKerja::where(
            'periode_tahunan_id',
            $periodeSebelumnya->id
        )
            ->orderBy('nomor')
            ->get();

        if ($programLama->isEmpty()) {
            return back()->with(
                'warning',
                'Tidak ada program kerja pada periode sebelumnya.'
            );
        }

        DB::transaction(function () use (
            $programLama,
            $periodeAktif
        ) {

            // Hapus data periode aktif jika ingin transfer ulang
            ProgramKerja::where(
                'periode_tahunan_id',
                $periodeAktif->id
            )->delete();

            $nomorBaru = 1;

            foreach ($programLama as $item) {

                ProgramKerja::create([

                    'periode_tahunan_id' => $periodeAktif->id,

                    'nomor'             => $nomorBaru++,

                    'uraian_kegiatan'   => $item->uraian_kegiatan,
                    'waktu_pelaksanaan' => $item->waktu_pelaksanaan,
                    'target'            => $item->target,
                    'sasaran'           => $item->sasaran,
                    'biaya'             => $item->biaya,
                    'penanggung_jawab'  => $item->penanggung_jawab,

                    'progress'          => 0,
                    'status_realisasi'  => 'belum',
                    'realisasi'         => null,
                    'kendala'           => null,
                    'catatan'           => null,
                    'tanggal_selesai'   => null,
                ]);
            }
        });

        return back()->with(
            'success',
            'Program kerja berhasil ditransfer dari periode '
                . $periodeSebelumnya->nama_periode
                . ' ke '
                . $periodeAktif->nama_periode
        );
    }
}
