<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $code = $user->code;

        /*
        |--------------------------------------------------------------------------
        | WILAYAH NAME
        |--------------------------------------------------------------------------
        */
        $wilayah = $this->getWilayahName($code);

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */
        $query = Pengamal::query();

        if ($code) {

            if (preg_match('/^\d{2}$/', $code)) {
                $query->where('provinsi', $code);
            } elseif (preg_match('/^\d{2}\.\d{2}$/', $code)) {
                $query->where('kabupaten', $code);
            } elseif (preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $code)) {
                $query->where('kecamatan', $code);
            } elseif (preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $code)) {
                $query->where('desa', $code);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GENDER STAT
        |--------------------------------------------------------------------------
        */
        $genderStat = (clone $query)
            ->selectRaw('jenis_kelamin, COUNT(*) as total')
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        /*
        |--------------------------------------------------------------------------
        | MAP REFERENCE (FIX PERFORMANCE - NO LOOP QUERY)
        |--------------------------------------------------------------------------
        */
        $regencyMap = Regency::pluck('name', 'code');
        $districtMap = District::pluck('name', 'code');
        $villageMap = Village::pluck('name', 'code');

        /*
        |--------------------------------------------------------------------------
        | WILAYAH STAT (BAR CHART)
        |--------------------------------------------------------------------------
        */
        $wilayahStat = ['labels' => [], 'values' => []];

        if (preg_match('/^\d{2}$/', $code)) {

            $data = Pengamal::query()
                ->selectRaw('kabupaten, COUNT(*) as total')
                ->where('provinsi', $code)
                ->groupBy('kabupaten')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $regencyMap[$i->kabupaten] ?? $i->kabupaten)->values()->toArray(),
                'values' => $data->pluck('total')->map(fn($v) => (int)$v)->values()->toArray(),
            ];
        } elseif (preg_match('/^\d{2}\.\d{2}$/', $code)) {

            $data = Pengamal::query()
                ->selectRaw('kecamatan, COUNT(*) as total')
                ->where('kabupaten', $code)
                ->groupBy('kecamatan')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $districtMap[$i->kecamatan] ?? $i->kecamatan)->values()->toArray(),
                'values' => $data->pluck('total')->map(fn($v) => (int)$v)->values()->toArray(),
            ];
        } elseif (preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $code)) {

            $data = Pengamal::query()
                ->selectRaw('desa, COUNT(*) as total')
                ->where('kecamatan', $code)
                ->groupBy('desa')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $villageMap[$i->desa] ?? $i->desa)->values()->toArray(),
                'values' => $data->pluck('total')->map(fn($v) => (int)$v)->values()->toArray(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | KABUPATEN (DOUGHNUT FIXED)
        |--------------------------------------------------------------------------
        */
        $provinceCode = substr($code, 0, 2);

        $kabupatenStats = Pengamal::query()
            ->selectRaw('kabupaten, COUNT(*) as total')
            ->when($code, fn($q) => $q->where('provinsi', $provinceCode))
            ->groupBy('kabupaten')
            ->get()
            ->map(function ($item) use ($regencyMap) {
                return [
                'label' => $regencyMap[$item->kabupaten] ?? $item->kabupaten,
                'total' => (int) $item->total,
            ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */
        /*
|--------------------------------------------------------------------------
| KATEGORI USIA (KANAK-KANAK / REMAJA / BAPAK / IBU)
|--------------------------------------------------------------------------
*/
        $kategoriStat = (clone $query)
            ->get()
            ->map(function ($item) {

                $usia = $item->tanggal_lahir
                    ? \Carbon\Carbon::parse($item->tanggal_lahir)->age
                    : null;

                $jk = strtolower(trim($item->jenis_kelamin ?? ''));

                if (!$usia) {
                    $kategori = 'Tidak diketahui';
                } elseif ($usia < 11) {
                    $kategori = 'Kanak-kanak';
                } elseif ($usia <= 35) {
                    $kategori = 'Remaja';
                } else {
                    $kategori = $jk === 'l' ? 'Bapak-bapak' : 'Ibu-ibu';
                }

                return $kategori;
            })
            ->countBy()
            ->toArray();
        return view('administrator.dashboard.index', [
            'user' => $user,
            'wilayah' => $wilayah,
            'genderStat' => $genderStat,
            'wilayahStat' => $wilayahStat,
            'kabupatenStats' => $kabupatenStats,
            'kategoriStat' => $kategoriStat,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | WILAYAH NAME
    |--------------------------------------------------------------------------
    */
    private function getWilayahName(?string $code): string
    {
        if (!$code) return 'Tidak diketahui';

        if (preg_match('/^\d{2}$/', $code)) {
            return Province::where('code', $code)->value('name') ?? 'Tidak diketahui';
        }

        if (preg_match('/^\d{2}\.\d{2}$/', $code)) {
            return Regency::where('code', $code)->value('name') ?? 'Tidak diketahui';
        }

        if (preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $code)) {
            return District::where('code', $code)->value('name') ?? 'Tidak diketahui';
        }

        if (preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $code)) {
            return Village::where('code', $code)->value('name') ?? 'Tidak diketahui';
        }

        return 'Tidak diketahui';
    }
}
