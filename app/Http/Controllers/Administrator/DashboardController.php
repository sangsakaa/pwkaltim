<?php

namespace App\Http\Controllers\Administrator;

use App\Models\User;
use App\Models\Pengamal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Ambil semua data terlebih dahulu (gunakan query builder, bukan collection)


        // Filter berdasarkan role
        $query = Pengamal::query();

        if ($user->hasRole('admin-kabupaten')) {
            $query->where('kabupaten', $user->code);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $query->where('kecamatan', $user->code);
        } elseif ($user->hasRole('admin-provinsi')) {
            $query->where('provinsi', $user->code);
        }

        // Ambil data sesuai role
        if ($user->hasRole('admin-provinsi')) {
            $data = $query->selectRaw('kabupaten, COUNT(*) as total')
                ->with('regency') // pastikan relasi ke tabel kabupaten
                ->groupBy('kabupaten')
                ->get();

            $labels = $data->map(function ($item) {
                $name = optional($item->regency)->name;
                return Str::startsWith($name, 'Kab.') ? 'Kabupaten ' . ltrim(substr($name, 4)) : $name;
            });
        } elseif ($user->hasRole('admin-kabupaten')) {
            $data = $query->selectRaw('kecamatan, COUNT(*) as total')
                ->with('district') // relasi ke kecamatan
                ->groupBy('kecamatan')
                ->get();

            $labels = $data->map(fn($item) => 'Kec. ' . optional($item->district)->name);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $data = $query->selectRaw('desa, COUNT(*) as total')
                ->with('village') // relasi ke desa
                ->groupBy('desa')
                ->get();

            $labels = $data->map(fn($item) => optional($item->village)->name);
        } else {
            $data = collect();
            $labels = collect();
        }

        $values = $data->pluck('total');



        return view(
            'administrator/dashboard/dashboard',
            [
                'user' => $user,
                'data' => $query,
                'labels' => $labels,
                'values' => $values
            ]
        );
    }
    
}
