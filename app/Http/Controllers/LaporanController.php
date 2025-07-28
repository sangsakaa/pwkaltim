<?php

namespace App\Http\Controllers;

use App\Models\Pengamal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function laporan()
    {
        $user = Auth::user();

        $query = Pengamal::query()->orderby('kecamatan', 'asc')->orderby('nama_lengkap', 'asc');

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
            ->setPaper([0, 0, 595.28, 935.43], 'landscape'); // F4 size in points
        // ->setPaper([0, 0, 595.28, 841.89], 'landscape');

        // Ganti download dengan stream agar hanya tampil di browser
        return $pdf->stream('laporan-data-pengamal.pdf');
    }
}
