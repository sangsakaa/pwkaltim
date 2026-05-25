<?php

namespace App\Http\Controllers;

use App\Models\Pengamal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporan()
    {
        $user = Auth::user();

        $query = Pengamal::query()
            ->with(['province', 'regency', 'district', 'village'])
            ->orderBy('kecamatan', 'asc')
            ->orderBy('nama_lengkap', 'asc');

        // Filter berdasarkan role
        if ($user->hasRole('admin-kabupaten')) {
            $query->where('kabupaten', $user->code);
        } elseif ($user->hasRole('admin-kecamatan')) {
            $query->where('kecamatan', $user->code);
        } elseif ($user->hasRole('admin-desa')) {
            $query->where('desa', $user->code);
        }

        $pengamal = $query->get();

        /**
         * Tambahkan usia + kategori
         */
        $pengamal->transform(function ($item) {

            $usia = $item->tanggal_lahir
                ? Carbon::parse($item->tanggal_lahir)->age
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

            $item->usia = $usia;
            $item->kategori = $kategori;

            return $item;
        });

        /**
         * Group kabupaten
         */
        $grouped = $pengamal->groupBy(fn($i) => $i->regency->name ?? 'Tanpa Kabupaten');

        /**
         * Rekap kategori per kabupaten & kecamatan
         */
        $kategoriGlobal = [];

        foreach ($grouped as $kabupaten => $items) {

            $kategoriGlobal[$kabupaten] = [];

            foreach ($items->groupBy(fn($i) => $i->district->name ?? 'Tanpa Kecamatan') as $kecamatan => $kecamatanItems) {

                $kategoriGlobal[$kabupaten][$kecamatan] = [
                    'Kanak-kanak' => 0,
                    'Remaja' => 0,
                    'Bapak-bapak' => 0,
                    'Ibu-ibu' => 0,
                    'Tidak diketahui' => 0,
                ];

                foreach ($kecamatanItems as $item) {
                    if (isset($kategoriGlobal[$kabupaten][$kecamatan][$item->kategori])) {
                        $kategoriGlobal[$kabupaten][$kecamatan][$item->kategori]++;
                    }
                }
            }
        }

        $data = [
            'title' => 'Laporan Data Pengamal',
            'pengamal' => $pengamal,
            'grouped' => $grouped,
            'kategoriGlobal' => $kategoriGlobal,
        ];

        $pdf = Pdf::loadView('administrator.laporan.lap', $data)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->stream('laporan-data-pengamal.pdf');
    }
}
