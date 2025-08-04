<?php

namespace App\Http\Controllers\Administrator;

use Carbon\Carbon;
use App\Models\Session;
use App\Models\Pengamal;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // 1. Pengguna aktif (online dalam 10 menit terakhir)
        $activeUsers = Session::with('user')
            ->where('last_activity', '>=', Carbon::now()->subMinutes(10)->timestamp)
            ->whereNotNull('user_id')
            ->get()
            ->pluck('user'); // hasil akhirnya kumpulan user aktif

        // 2. Log aktivitas pengguna saat ini
        $userLogs = Activity::causedBy($user)->get();

        // 3. Query utama data Pengamal berdasarkan role
        // 6. Statistik jenis kelamin
        $jumlahByGender = Pengamal::query()
            ->when($user->hasRole('admin-provinsi'), fn($q) => $q->where('provinsi', $user->code))
            ->when($user->hasRole('admin-kabupaten'), fn($q) => $q->where('kabupaten', $user->code))
            ->when($user->hasRole('admin-kecamatan'), fn($q) => $q->where('kecamatan', $user->code))
            ->select('jenis_kelamin', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');
        $data = collect();
        $labels = collect();
        $values = collect();

        $query = Pengamal::query()
            ->when($user->hasRole(['admin-provinsi', 'superAdmin']), fn($q) => $q)
            ->when($user->hasRole('admin-kabupaten'), fn($q) => $q->where('kabupaten', $user->code))
            ->when($user->hasRole('admin-kecamatan'), fn($q) => $q->where('kecamatan', $user->code));

        if ($user->hasRole(['admin-provinsi', 'superAdmin'])) {
            $data = $query->selectRaw('kabupaten, COUNT(*) as total')
                ->with('regency')
                ->groupBy('kabupaten')
                ->get();

            $labels = $data->map(
                fn($item) =>
                Str::startsWith(optional($item->regency)->name, 'Kab.')
                    ? 'Kabupaten ' . ltrim(substr(optional($item->regency)->name, 4))
                    : optional($item->regency)->name
            );
        } elseif ($user->hasRole('admin-kabupaten')) {
            $data = $query->selectRaw('kecamatan, COUNT(*) as total')
                ->with('district')
                ->groupBy('kecamatan')
                ->get();

            $labels = $data->map(fn($item) => 'Kec. ' . optional($item->district)->name);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $data = $query->selectRaw('desa, COUNT(*) as total')
                ->with('village')
                ->groupBy('desa')
                ->get();

            $labels = $data->map(function ($item) {
                $name = optional($item->village)->name;
                return Str::startsWith($name, 'Desa') ? $name : 'Desa ' . $name;
            });
        }

        $values = $data->pluck('total');

        // 7. Return view dengan semua data
        return view('administrator/dashboard/dashboard', [
            'user' => $user,


            'jumlahByGender' => $jumlahByGender,
            'userLogs' => $userLogs,
            'activeUsers' => $activeUsers,
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
