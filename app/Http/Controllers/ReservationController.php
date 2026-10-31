<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;


class ReservationController extends Controller
{
    public function create()
    {
        return view(
            'reservations.create',
            [
                'provinces' => Province::whereIn(
                    'code',
                    [61, 62, 63, 64, 65]
                )->orderBy('name')->get()
            ]
        );
    }

    /**
     * Simpan reservasi
     */
    public function store(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([

            'type' => 'required|in:personal,group',

            'ketua_rombongan' => 'nullable|string|max:255',

            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',

            'address' => 'nullable|string',

            // DATA KENDARAAN
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_name' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:255',

            // JUMLAH PESERTA
            'total_father' => 'nullable|integer|min:0',
            'total_mother' => 'nullable|integer|min:0',
            'total_teenager' => 'nullable|integer|min:0',
            'total_child' => 'nullable|integer|min:0',

        ]);

        DB::beginTransaction();

        try {

            // NOMOR RESERVASI
            $lastId = (Reservation::max('id') ?? 0) + 1;

            $reservationNumber =
                'RSV-' .
                now()->format('Ymd') .
                '-' .
                str_pad(
                    $lastId,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            // KODE RESERVASI
            $reservationCode = strtoupper(
                Str::random(8)
            );

            // TOTAL PESERTA
            $totalFather = $validated['total_father'] ?? 0;
            $totalMother = $validated['total_mother'] ?? 0;
            $totalTeenager = $validated['total_teenager'] ?? 0;
            $totalChild = $validated['total_child'] ?? 0;

            $totalParticipant =
                $totalFather +
                $totalMother +
                $totalTeenager +
                $totalChild;

            // SIMPAN DATA RESERVASI
            $reservation = Reservation::create([

                'ketua_rombongan' =>
                $validated['ketua_rombongan'] ?? null,

                'reservation_number' =>
                $reservationNumber,

                'reservation_code' =>
                $reservationCode,

                'type' =>
                $validated['type'],

                'regency_id' =>
                $validated['regency_id'],

                'district_id' =>
                $validated['district_id'],

                'village_id' =>
                $validated['village_id'],

                'address' =>
                $validated['address'] ?? null,

                // KENDARAAN
                'vehicle_type' =>
                $validated['vehicle_type'] ?? null,

                'vehicle_name' =>
                $validated['vehicle_name'] ?? null,

                'vehicle_number' =>
                $validated['vehicle_number'] ?? null,

                // JUMLAH PESERTA
                'total_father' =>
                $totalFather,

                'total_mother' =>
                $totalMother,

                'total_teenager' =>
                $totalTeenager,

                'total_child' =>
                $totalChild,

                'total_participant' =>
                $totalParticipant,

                // STATUS
                'status' => 'pending',

            ]);

            // GENERATE QR CODE
            $directory = storage_path(
                'app/public/qrcodes'
            );

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $fileName = $reservationCode . '.svg';

            $path = $directory . '/' . $fileName;

            QrCode::format('svg')
                ->size(300)
                ->generate(
                    $reservationCode,
                    $path
                );

            // COMMIT
            DB::commit();

            // REDIRECT
            return redirect()->route(
                'reservasi.show',
                $reservation->id
            );
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function show($id)
    {
        $reservation =
            Reservation::findOrFail($id);

        return view(
            'reservations.show',
            compact('reservation')
        );
    }
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $data = $request->validate(['total_father' => 'required|integer|min:0', 'total_mother' => 'required|integer|min:0', 'total_teenager' => 'required|integer|min:0', 'total_child' => 'required|integer|min:0',]);
        $data['total_participant'] = $data['total_father'] + $data['total_mother'] + $data['total_teenager'] + $data['total_child'];
        $reservation->update($data);
        return redirect()->back()->with('success', 'Jumlah peserta berhasil diperbarui');
    }
    
public function lookup()
{
        return view('reservations.lookup');
}

public function edit($id)
{
    $reservation = Reservation::findOrFail($id);

    return view(
            'reservations.edit',
        compact('reservation')
    );
}

    public function find(Request $request)
    {
        $request->validate([
            'reservation_code' => 'required'
        ]);

        $reservation = Reservation::where(
            'reservation_code',
            trim($request->reservation_code)
        )->first();

        if (!$reservation) {
            return back()->with(
                'error',
                'Kode reservasi tidak ditemukan'
            );
        }

        return redirect()->route(
            'reservasi.edit',
            $reservation->id
        );
    }
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status' => 'no_show'
        ]);

        return back()->with(
            'success',
            'Reservasi berhasil dibatalkan'
        );
    }
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        return back()->with(
            'success',
            'Reservasi berhasil dihapus'
        );
    }

    public function report()
    {
        $reservations = Reservation::with([
            'regency.province',
            'district',
            'village',
        ])
            ->orderBy('ketua_rombongan')
            ->get();

        $totalBapak = $reservations->sum('total_father');
        $totalIbu = $reservations->sum('total_mother');
        $totalRemaja = $reservations->sum('total_teenager');
        $totalAnak = $reservations->sum('total_child');
        $totalPeserta = $reservations->sum('total_participant');

        return view('reservations.report', compact(
            'reservations',
            'totalBapak',
            'totalIbu',
            'totalRemaja',
            'totalAnak',
            'totalPeserta'
        ));
    }

    public function reportPdf()
    {
        $reservations = Reservation::with([
            'regency.province',
            'district',
            'village',
        ])
            ->orderBy('ketua_rombongan')
            ->get();

        // Kelompok utama: provinsi, lalu kabupaten/kota
        $grouped = $reservations
            ->groupBy(function ($reservation) {
                return $reservation->regency?->province?->name
                    ?? 'Provinsi tidak diketahui';
            })
            ->map(function ($provinceReservations) {
                return $provinceReservations->groupBy(function ($reservation) {
                    return $reservation->regency?->name
                        ?? 'Kabupaten tidak diketahui';
                });
            })
            ->sortKeys();

        $totalBapak = $reservations->sum('total_father');
        $totalIbu = $reservations->sum('total_mother');
        $totalRemaja = $reservations->sum('total_teenager');
        $totalAnak = $reservations->sum('total_child');
        $totalPeserta = $reservations->sum('total_participant');

        $pdf = Pdf::loadView('reservations.report-pdf', compact(
            'grouped',
            'totalBapak',
            'totalIbu',
            'totalRemaja',
            'totalAnak',
            'totalPeserta'
        ));

        $pdf->setPaper('a4', 'landscape');

        // return $pdf->download('laporan-reservasi.pdf');
        return $pdf->stream('laporan-reservasi.pdf');
    }
}
