<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $user = User::where('id', $user->id)
            ->with(['province', 'regency'])
            ->first();



        $dataPengamal = \App\Models\Pengamal::count();
        $dataKab = \App\Models\Pengamal::get();
        $jumlahPerProvinsi = $dataKab->groupBy('district.name')->map(function ($item) {
            return count($item);
        });
        return view(
            'administrator/dashboard/dashboard',
            [
                'labels' => $jumlahPerProvinsi->keys(),   // Nama provinsi
                'data' => $jumlahPerProvinsi->values(),
                'dataPengamal' => $dataPengamal,  // Jumlah per provinsi
                'user' => $user, // Data user pengamal
            ]
        );
    }
    
}
