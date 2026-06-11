<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationController extends Controller
{
    public function create()
    {
        return view(
            'reservations.create',
            [
                'provinces' => Province::where('code', 64)->get()
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',

            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',

            'vehicle_type' => 'nullable',
            'vehicle_name' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:255',

            'total_father' => 'nullable|integer|min:0',
            'total_mother' => 'nullable|integer|min:0',
            'total_teenager' => 'nullable|integer|min:0',
            'total_child' => 'nullable|integer|min:0',
            'ketua_rombongan' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();

        try {

            $lastId = Reservation::max('id') + 1;

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

            $reservationCode =
                strtoupper(
                    Str::random(8)
                );

            $totalParticipant =
                ($request->total_father ?? 0) +
                ($request->total_mother ?? 0) +
                ($request->total_teenager ?? 0) +
                ($request->total_child ?? 0);

            $reservation = Reservation::create([
                'ketua_rombongan' => $request->ketua_rombongan,
                'reservation_number'
                => $reservationNumber,

                'reservation_code'
                => $reservationCode,

                'type'
                => $request->type,

                'regency_id'
                => $request->regency_id,

                'district_id'
                => $request->district_id,

                'village_id'
                => $request->village_id,

                'address'
                => $request->address,

                'vehicle_type' => $request->vehicle_type ?? null,
                'vehicle_name' => $request->vehicle_name ?? null,
                'vehicle_number' => $request->vehicle_number ?? null,

                'total_father'
                => $request->total_father ?? 0,

                'total_mother'
                => $request->total_mother ?? 0,

                'total_teenager'
                => $request->total_teenager ?? 0,

                'total_child'
                => $request->total_child ?? 0,

                'total_participant'
                => $totalParticipant,

                'status'
                => 'pending',
            ]);

            $fileName =
                $reservationCode . '.svg';

            $path =
                storage_path(
                    'app/public/qrcodes/' .
                        $fileName
                );

            QrCode::format('svg')
                ->size(300)
                ->generate(
                    $reservationCode,
                    $path
                );

            DB::commit();

            return redirect()->route(
                'reservasi.show',
                $reservation->id
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
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
}
