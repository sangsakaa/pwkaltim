<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dataPengamal = \App\Models\Pengamal::count();
        $dataKab = \App\Models\Pengamal::get();
        $jumlahPerProvinsi = $dataKab->groupBy('regency.name')->map(function ($item) {
            return count($item);
        });
        return view(
            'administrator/dashboard/dashboard',
            [
                'labels' => $jumlahPerProvinsi->keys(),   // Nama provinsi
                'data' => $jumlahPerProvinsi->values(),
                'dataPengamal' => $dataPengamal,  // Jumlah per provinsi
            ]
        );
    }
    
}
