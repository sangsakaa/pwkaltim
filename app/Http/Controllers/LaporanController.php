<?php

namespace App\Http\Controllers;

use App\Models\Pengamal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function laporan()
    {
        $user = auth()->user();

        $query = Pengamal::query()->orderby('kecamatan', 'asc');

        if ($user->hasRole('admin-kabupaten')) {
            $query->where('kabupaten', $user->code);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $query->where('kecamatan', $user->code);
        } elseif ($user->hasRole('admin-desa')) {
            $query->where('desa', $user->code);
        }

        $pengamal = $query->get();

        $data = [
            'title' => 'Laporan Data Pengamal',
            'pengamal' => $pengamal,
        ];

        $pdf = Pdf::loadView('administrator.laporan.lap', $data)
            ->setPaper('F4', 'landscape');

        // Ganti download dengan stream agar hanya tampil di browser
        return $pdf->stream('laporan-data-pengamal.pdf');
    }
}
