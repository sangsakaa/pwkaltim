<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationScan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        $totalReservation = Reservation::count();

        $checkedIn = Reservation::where(
            'status',
            'checked_in'
        )->count();

        $pending = Reservation::where(
            'status',
            'pending'
        )->count();

        return view(
            'panitia.dashboard',
            compact(
                'totalReservation',
                'checkedIn',
                'pending'
            )
        );
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
                    'message' => 'Kode reservasi tidak ditemukan'
                ], 404);
            }

            if ($reservation->status === 'checked_in') {
                return response()->json([
                    'message' => 'Pengunjung sudah check-in'
                ], 409);
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
                'message' => 'Check-in berhasil',
                'data' => [
                    'ketua_rombongan' => $reservation->ketua_rombongan,
                    'reservation_number' => $reservation->reservation_number,
                    'reservation_code' => $reservation->reservation_code,
                    'participant' => $reservation->total_participant ?? '-'
                ]
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reservations()
    {
        $reservations = Reservation::query()
            ->latest()
            ->paginate(20);

        return view(
            'panitia.reservations.index',
            [
                'title' => 'Data Reservasi',
                'reservations' => $reservations
            ]
        );
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
}
