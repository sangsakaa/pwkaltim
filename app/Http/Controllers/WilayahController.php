<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;

class WilayahController extends Controller
{
    public function index()
    {
        $provinceCode = 64;

        $prov = Province::where('code', $provinceCode)->get();

        $kab = Regency::where('province_code', $provinceCode)
            ->orderBy('code')
            ->get();

        $kec = District::orderBy('code')->get();

        return view('administrator.wilayah.index', compact(
            'prov',
            'kab',
            'kec'
        ));
    }

    public function show($regency)
    {
        $kec = District::where('regency_code', $regency)
            ->orderBy('code')
            ->get();

        return view('administrator.wilayah.show', compact(
            'regency',
            'kec'
        ));
    }

    public function detailshow($regency)
    {
        $desa = Village::where('district_code', $regency)
            ->orderBy('code')
            ->get();

        return view('administrator.wilayah.detailshow', compact(
            'regency',
            'desa'
        ));
    }
}
