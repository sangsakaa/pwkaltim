<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationScan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        $reservations = Reservation::query();

        return view('panitia.dashboard', [
            'totalReservation' => (clone $reservations)->count(),

            'checkedIn' => (clone $reservations)
                ->where('status', 'checked_in')
                ->count(),

            'pending' => (clone $reservations)
                ->where('status', 'pending')
                ->count(),

            'totalParticipant' => (clone $reservations)
                ->sum('total_participant'),

            'totalFather' => (clone $reservations)
                ->sum('total_father'),

            'totalMother' => (clone $reservations)
                ->sum('total_mother'),

            'totalTeenager' => (clone $reservations)
                ->sum('total_teenager'),

            'totalChild' => (clone $reservations)
                ->sum('total_child'),
        ]);
    }

    public function scan()
    {
        return view('panitia.scan');
    }
    public function checkin(Request $request)
    {
        try {

            $request->validate([
                'reservation_code' => 'required'
            ]);

            $reservation = Reservation::where(
                'reservation_code',
                trim($request->reservation_code)
            )->first();

            if (!$reservation) {

                return response()->json([
                    'success' => false,
                    'message' => 'Kode reservasi tidak ditemukan'
                ], 404);
            }

            if ($reservation->status === 'checked_in') {

                return response()->json([
                    'success' => false,
                    'message' => 'Pengunjung sudah check-in'
                ], 422);
            }

            if ($reservation->status === 'no_show') {

                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi telah dibatalkan'
                ], 422);
            }

            $reservation->update([
                'status' => 'checked_in',
                'checked_in_at' => now()
            ]);

            ReservationScan::create([
                'reservation_id' => $reservation->id,
                'scanned_by' => auth()->id(),
                'scan_time' => now(),
                'notes' => 'QR Auto Check-in'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil',
                'data' => [
                    'ketua_rombongan' => $reservation->ketua_rombongan,
                    'reservation_number' => $reservation->reservation_number,
                    'reservation_code' => $reservation->reservation_code,
                    'participant' => $reservation->total_participant,
                    'status' => $reservation->status,
                ]
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reservations(\Illuminate\Http\Request $request)
    {
        $search = trim($request->input('search', ''));

        $reservations = Reservation::query()
            ->with(['regency', 'district', 'village'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reservation_number', 'like', "%{$search}%")
                        ->orWhere('reservation_code', 'like', "%{$search}%")
                        ->orWhere('ketua_rombongan', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('regency', function ($r) use ($search) {
                            $r->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('district', function ($d) use ($search) {
                            $d->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('village', function ($v) use ($search) {
                            $v->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('panitia.reservations.index', [
            'title' => 'Data Reservasi',
            'reservations' => $reservations,
            'search' => $search,
        ]);
    }

    public function checkedIn()
    {
        $reservations = Reservation::where(
            'status',
            'checked_in'
        )
            ->latest()
            ->paginate(20);

        return view(
            'panitia.reservations.index',
            [
                'title' => 'Sudah Check-in',
                'reservations' => $reservations
            ]
        );
    }

    public function pending()
    {
       
    $reservations = Reservation::where(
            'status',
            'pending'
        )
            ->latest()
            ->paginate(20);

        return view(
            'panitia.reservations.index',
            [
                'title' => 'Belum Check-in',
                'reservations' => $reservations
            ]
        );
    }
    public function cancelledReservations()
    {
        $reservations = Reservation::where('status', 'no_show')
            ->latest()
            ->paginate(20);

        return view(
            'panitia.reservations.index',
            [
                'title' => 'Reservasi Dibatalkan',
                'reservations' => $reservations
            ]
        );
    }


    public function printCard(Reservation $reservation)
    {
        if ($reservation->status === 'no_show') {
            return redirect()
                ->route('admin.reservasi.data')
                ->with('error', 'Reservasi dibatalkan. Kartu aktif tidak dapat dicetak.');
        }

        $reservation->load(['regency', 'district', 'village']);

        return view('panitia.reservations.card', compact('reservation'));
    }


    public function restorePending(Reservation $reservation)
    {
        // Hanya reservasi Dibatalkan atau Sudah Check-in yang dapat dipulihkan
        if (!in_array($reservation->status, ['no_show', 'checked_in'], true)) {
            return redirect()
                ->route('admin.reservasi.data')
                ->with('error', 'Hanya reservasi Dibatalkan atau Sudah Check-in yang dapat dikembalikan ke Pending.');
        }

        try {
            // Kembalikan status reservasi
            $reservation->status = 'pending';
            $reservation->marked_no_show_at = null;
            $reservation->checked_in_at = null;
            $reservation->save();

            return redirect()
                ->route('admin.reservasi.data')
                ->with('success', 'Reservasi berhasil dikembalikan ke Pending.');
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.reservasi.data')
                ->with('error', 'Gagal mengembalikan reservasi. Silakan periksa log aplikasi.');
        }
    }
    public function exportPdf()
    {
        $reservations = Reservation::with([
            'regency.province',
            'district',
            'village',
        ])
            ->orderBy('ketua_rombongan')
            ->get();

        // Kelompokkan berdasarkan provinsi, lalu kabupaten/kota
        $grouped = $reservations
            ->groupBy(function ($reservation) {
                return $reservation->regency?->province?->name
                    ?? 'Provinsi tidak diketahui';
            })
            ->map(function ($provinceReservations) {
                return $provinceReservations
                    ->groupBy(function ($reservation) {
                        return $reservation->regency?->name
                            ?? 'Kabupaten tidak diketahui';
                    })
                    ->sortKeys();
            })
            ->sortKeys();

        // Hitung total peserta
        $totalBapak = $reservations->sum('total_father');
        $totalIbu = $reservations->sum('total_mother');
        $totalRemaja = $reservations->sum('total_teenager');
        $totalAnak = $reservations->sum('total_child');
        $totalPeserta = $reservations->sum('total_participant');

        // Buat PDF
        $pdf = Pdf::loadView('reservations.report-pdf', compact(
            'grouped',
            'totalBapak',
            'totalIbu',
            'totalRemaja',
            'totalAnak',
            'totalPeserta'
        ));

        // $pdf->setPaper('a4', 'landscape');
        $pdf->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->stream('laporan-reservasi.pdf');
    }
}
