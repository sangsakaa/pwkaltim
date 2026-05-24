<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\ProgramKerja;
use App\Models\Province;
use App\Models\Regency;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $baseQuery = $this->basePengamalQuery($user);

        return view('administrator.dashboard.dashboard', [
            'user'           => $user,
            'genderStat'     => $this->getGenderStat($baseQuery),
            'wilayahStat'    => $this->getWilayahStat($user),
            'kabupatenStats' => $this->getKabupatenStat($baseQuery),
            'surat'          => $this->getSuratStat(),
            'biaya'          => $this->getBiayaStat(),
            'programKerja'   => ProgramKerja::count(),
        ]);
    }

    /**
     * Query dasar sesuai role
     */
    private function basePengamalQuery($user)
    {
        $query = Pengamal::query();

        return match (true) {
            $user->hasRole('superAdmin')
            => $query,

            $user->hasRole('admin-provinsi')
            => $query->where('provinsi', $user->code),

            $user->hasRole('admin-kabupaten')
            => $query->where('kabupaten', $user->code),

            $user->hasRole('admin-kecamatan')
            => $query->where('kecamatan', $user->code),

            $user->hasRole('admin-desa')
            => $query->where('desa', $user->code),

            default => abort(403, 'Unauthorized'),
        };
    }

    /**
     * Statistik gender
     */
    private function getGenderStat($query)
    {
        return (clone $query)
            ->select('jenis_kelamin', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');
    }

    /**
     * Statistik kabupaten
     */
    private function getKabupatenStat($query)
    {
        $data = (clone $query)
            ->selectRaw('kabupaten, COUNT(*) as total')
            ->groupBy('kabupaten')
            ->orderByDesc('total')
            ->get();

        return $data->map(function ($item) {

            $regency = Regency::where(
                'code',
                $item->kabupaten
            )->first();

            return [
                'label' => $regency?->name
                    ?? 'Tidak diketahui',

                'total' => (int) $item->total,
            ];
        });
    }

    /**
     * Statistik wilayah
     */
    private function getWilayahStat($user)
    {
        $query = $this->basePengamalQuery($user);

        if (
            $user->hasRole('superAdmin') ||
            $user->hasRole('admin-provinsi')
        ) {
            return $this->buildWilayahStat(
                $query,
                'kabupaten',
                Regency::class
            );
        }

        if ($user->hasRole('admin-kabupaten')) {
            return $this->buildWilayahStat(
                $query,
                'kecamatan',
                District::class
            );
        }

        if ($user->hasRole('admin-kecamatan')) {
            return $this->buildWilayahStat(
                $query,
                'desa',
                Village::class
            );
        }

        if ($user->hasRole('admin-desa')) {
            return [
                'labels' => ['Pengamal'],
                'values' => [(clone $query)->count()],
            ];
        }

        return [
            'labels' => [],
            'values' => [],
        ];
    }

    /**
     * Builder statistik reusable
     */
    private function buildWilayahStat(
        $query,
        $column,
        $modelClass
    ) {
        $data = (clone $query)
            ->selectRaw("$column, COUNT(*) as total")
            ->groupBy($column)
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $data
                ->map(function ($item) use (
                    $column,
                    $modelClass
                ) {

                $wilayah = $modelClass::where(
                    'code',
                    $item->$column
                )->first();

                    return $wilayah?->name
                        ?? 'Tidak diketahui';
                })
                ->values()
                ->toArray(),

            'values' => $data
                ->pluck('total')
                ->map(fn($v) => (int) $v)
                ->values()
                ->toArray(),
        ];
    }

    /**
     * Statistik surat
     */
    private function getSuratStat()
    {
        return [
            'masuk'  => SuratMasuk::count(),
            'keluar' => SuratKeluar::count(),
        ];
    }

    /**
     * Statistik biaya
     */
    private function getBiayaStat()
    {
        return ProgramKerja::select(
            'waktu_pelaksanaan',
            DB::raw('SUM(biaya) as total')
        )
            ->groupBy('waktu_pelaksanaan')
            ->pluck('total', 'waktu_pelaksanaan');
    }
}
