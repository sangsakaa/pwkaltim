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
    | BASE QUERY (FILTER WILAYAH)
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
    | MAP (OPTIMIZED)
    |--------------------------------------------------------------------------
    */
        $regencyMap = Regency::pluck('name', 'code');
        $districtMap = District::pluck('name', 'code');
        $villageMap = Village::pluck('name', 'code');

        /*
    |--------------------------------------------------------------------------
    | WILAYAH STAT
    |--------------------------------------------------------------------------
    */
        $wilayahStat = ['labels' => [], 'values' => []];

        if (preg_match('/^\d{2}$/', $code)) {

            $data = Pengamal::where('provinsi', $code)
                ->selectRaw('kabupaten, COUNT(*) as total')
                ->groupBy('kabupaten')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $regencyMap[$i->kabupaten] ?? $i->kabupaten)->values()->toArray(),
                'values' => $data->pluck('total')->toArray(),
            ];
        } elseif (preg_match('/^\d{2}\.\d{2}$/', $code)) {

            $data = Pengamal::where('kabupaten', $code)
                ->selectRaw('kecamatan, COUNT(*) as total')
                ->groupBy('kecamatan')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $districtMap[$i->kecamatan] ?? $i->kecamatan)->values()->toArray(),
                'values' => $data->pluck('total')->toArray(),
            ];
        } elseif (preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $code)) {

            $data = Pengamal::where('kecamatan', $code)
                ->selectRaw('desa, COUNT(*) as total')
                ->groupBy('desa')
                ->get();

            $wilayahStat = [
                'labels' => $data->map(fn($i) => $villageMap[$i->desa] ?? $i->desa)->values()->toArray(),
                'values' => $data->pluck('total')->toArray(),
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | KATEGORI USIA (GLOBAL)
    |--------------------------------------------------------------------------
    */
        $kategoriStat = (clone $query)
            ->get()
            ->map(function ($item) {

                $usia = $item->tanggal_lahir
                    ? \Carbon\Carbon::parse($item->tanggal_lahir)->age
                    : null;

                $jk = strtolower($item->jenis_kelamin ?? '');

                if (!$usia) return 'Tidak diketahui';

                if ($usia <= 10) return 'Kanak-kanak';
                if ($usia <= 35) return 'Remaja';

                return $jk === 'l' ? 'Bapak-bapak' : 'Ibu-ibu';
            })
            ->countBy()
            ->toArray();

        /*
    |--------------------------------------------------------------------------
    | 🔥 KABUPATEN + USIA (STACKED CHART READY)
    |--------------------------------------------------------------------------
    */
        $kabupatenStats = Pengamal::query()
            ->selectRaw("
            kabupaten,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 10 THEN 1 ELSE 0 END) AS anak,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 11 AND 35 THEN 1 ELSE 0 END) AS remaja,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 35 AND jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS bapak,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 35 AND jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS ibu
        ")
            ->when($code, fn($q) => $q->where('provinsi', substr($code, 0, 2)))
            ->groupBy('kabupaten')
            ->get()
            ->map(function ($item) use ($regencyMap) {
                return [
                'label'   => $regencyMap[$item->kabupaten] ?? $item->kabupaten,
                'anak'    => (int) $item->anak,
                'remaja'  => (int) $item->remaja,
                'bapak'   => (int) $item->bapak,
                'ibu'     => (int) $item->ibu,
            ];
            })
            ->values();

        /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */
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
