<?php

namespace App\Http\Controllers\Administrator;

use Carbon\Carbon;
use App\Models\Pengamal;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
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


        // usia
        $usiaGroups = [
            '0-10' => 0,
            '11-20' => 0,
            '21-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '51+' => 0,
        ];

        $tanggalLahirList = $query->pluck('tanggal_lahir');
        // $jumlahByGender = $query->select('jenis_kelamin', DB::raw('count(*) as total'))
        //     ->groupBy('jenis_kelamin')
        //     ->pluck('total', 'jenis_kelamin');

        foreach ($tanggalLahirList as $tanggalLahir) {
            $usia = Carbon::parse($tanggalLahir)->age;

            if ($usia <= 10) {
                $usiaGroups['0-10']++;
            } elseif ($usia <= 20) {
                $usiaGroups['11-20']++;
            } elseif ($usia <= 30) {
                $usiaGroups['21-30']++;
            } elseif ($usia <= 40) {
                $usiaGroups['31-40']++;
            } elseif ($usia <= 50) {
                $usiaGroups['41-50']++;
            } else {
                $usiaGroups['51+']++;
            }
        }

        // Gabungkan ke kategori besar
        $total = array_sum($usiaGroups);

        $kategoriUsia = [
            'Anak-anak' => $usiaGroups['0-10'],
            'Remaja' => $usiaGroups['11-20'] + $usiaGroups['21-30'],
            'Dewasa' => $usiaGroups['31-40'] + $usiaGroups['41-50'],
            'Lanjut Usia' => $usiaGroups['51+'],
        ];

        $persentaseKategori = [];
        foreach ($kategoriUsia as $kategori => $jumlah) {
            $persentaseKategori[$kategori] = $total > 0 ? round(($jumlah / $total) * 100, 2) : 0;
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
                'values' => $values,
                // 'jumlahByGender' => $jumlahByGender,
                'kategoriUsia' => $kategoriUsia,
                'persentaseKategori' => $persentaseKategori
            ]
        );
    }
    
}
