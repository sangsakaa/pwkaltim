<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Pengamal;
use App\Models\Regency;
use App\Models\Village;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole([
            'admin-provinsi',
            'admin-kabupaten',
            'admin-kecamatan',
            'admin-desa',
            'superAdmin'
        ])) {
            abort(403, 'Unauthorized');
        }

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */
        $query = Pengamal::query()
            ->with(['province', 'regency', 'district', 'village']);

        $this->filterWilayah($query, $user);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        $query->when($request->filled('search'), function ($q) use ($request) {

            $search = $request->search;

            $q->where(function ($sub) use ($search) {
                $sub->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        });

        $dataPengamal = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DATA FILTER DROPDOWN
        |--------------------------------------------------------------------------
        */
        $kabupaten = Regency::where('code', 'like', '64.%')
            ->orderBy('name')
            ->get();

        $kecamatan = District::where('code', 'like', '64.%')
            ->orderBy('name')
            ->get();

        $desa = Village::where('code', 'like', '64.%')
            ->orderBy('name')
            ->get();

        return view('administrator.laporan.index', [
            'dataPengamal' => $dataPengamal,
            'kabupaten'    => $kabupaten,
            'kecamatan'    => $kecamatan,
            'desa'         => $desa,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER WILAYAH BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */
    private function filterWilayah($query, $user)
    {
        if ($user->hasRole('admin-provinsi')) {
            $query->where('provinsi', $user->code);
        }

        if ($user->hasRole('admin-kabupaten')) {
            $query->where('kabupaten', $user->code);
        }

        if ($user->hasRole('admin-kecamatan')) {
            $query->where('kecamatan', $user->code);
        }

        if ($user->hasRole('admin-desa')) {
            $query->where('desa', $user->code);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE DATA PDF
    |--------------------------------------------------------------------------
    */
    private function getLaporanData($request = null)
    {
        $user = Auth::user();

        $query = Pengamal::query()
            ->with(['province', 'regency', 'district', 'village'])
            ->orderBy('kecamatan')
            ->orderBy('nama_lengkap');

        /*
        |--------------------------------------------------------------------------
        | FILTER ROLE
        |--------------------------------------------------------------------------
        */
        $this->filterWilayah($query, $user);

        /*
        |--------------------------------------------------------------------------
        | FILTER REQUEST
        |--------------------------------------------------------------------------
        */
        if ($request) {

            if ($request->filled('kabupaten')) {
                $query->where('kabupaten', $request->kabupaten);
            }

            if ($request->filled('kecamatan')) {
                $query->where('kecamatan', $request->kecamatan);
            }

            if ($request->filled('desa')) {
                $query->where('desa', $request->desa);
            }
        }

        $pengamal = $query->get();

        /*
        |--------------------------------------------------------------------------
        | TAMBAH USIA & KATEGORI
        |--------------------------------------------------------------------------
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
                $kategori = $jk === 'l'
                    ? 'Bapak-bapak'
                    : 'Ibu-ibu';
            }

            $item->usia = $usia;
            $item->kategori = $kategori;

            return $item;
        });

        /*
        |--------------------------------------------------------------------------
        | GROUP BY KABUPATEN
        |--------------------------------------------------------------------------
        */
        $grouped = $pengamal->groupBy(
            fn($i) => $i->regency->name ?? 'Tanpa Kabupaten'
        );

        /*
        |--------------------------------------------------------------------------
        | REKAP KATEGORI
        |--------------------------------------------------------------------------
        */
        $kategoriGlobal = [];

        foreach ($grouped as $kabupaten => $items) {

            $kategoriGlobal[$kabupaten] = [];

            foreach (
                $items->groupBy(
                    fn($i) => $i->district->name ?? 'Tanpa Kecamatan'
                ) as $kecamatan => $kecamatanItems
            ) {

                $kategoriGlobal[$kabupaten][$kecamatan] = [
                    'Kanak-kanak'     => 0,
                    'Remaja'          => 0,
                    'Bapak-bapak'     => 0,
                    'Ibu-ibu'         => 0,
                    'Tidak diketahui' => 0,
                ];

                foreach ($kecamatanItems as $item) {
                    $kategoriGlobal[$kabupaten][$kecamatan][$item->kategori]++;
                }
            }
        }

        return [
            'title'           => 'Laporan Data Pengamal',
            'pengamal'        => $pengamal,
            'grouped'         => $grouped,
            'kategoriGlobal'  => $kategoriGlobal,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STREAM PDF
    |--------------------------------------------------------------------------
    */
    public function laporan()
    {
        $data = $this->getLaporanData();

        $pdf = Pdf::loadView(
            'administrator.laporan.lap',
            $data
        )->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->stream('laporan-data-pengamal.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF
    |--------------------------------------------------------------------------
    */
    public function downloadLaporan(Request $request)
    {
        $data = $this->getLaporanData($request);

        /*
    |--------------------------------------------------------------------------
    | NAMA FILE
    |--------------------------------------------------------------------------
    */
        $wilayah = 'semua-wilayah';

        // Prioritas: desa > kecamatan > kabupaten
        if ($request->filled('desa')) {

            $desa = Village::where('code', $request->desa)->first();

            $wilayah = $desa?->name ?? 'desa';
        } elseif ($request->filled('kecamatan')) {

            $kecamatan = District::where('code', $request->kecamatan)->first();

            $wilayah = $kecamatan?->name ?? 'kecamatan';
        } elseif ($request->filled('kabupaten')) {

            $kabupaten = Regency::where('code', $request->kabupaten)->first();

            $wilayah = $kabupaten?->name ?? 'kabupaten';
        }

        // Bersihkan nama file
        $wilayah = strtolower($wilayah);
        $wilayah = str_replace([' ', '/', '\\'], '-', $wilayah);

        // tanggal download
        $tanggal = now()->format('Y-m-d');

        $namaFile = "laporan-pengamal-{$wilayah}-{$tanggal}.pdf";

        /*
    |--------------------------------------------------------------------------
    | GENERATE PDF
    |--------------------------------------------------------------------------
    */
        $pdf = Pdf::loadView(
            'administrator.laporan.lap',
            $data
        )->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->stream($namaFile);
    }
}
