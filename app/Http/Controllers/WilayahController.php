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

        return view('administrator.wilayah.index', compact('prov'));
    }

    // Kabupaten/Kota berdasarkan provinsi
    public function province($provinceCode)
    {
        $province = Province::where('code', $provinceCode)
            ->firstOrFail();

        $kab = Regency::where('province_code', $provinceCode)
            ->orderBy('code')
            ->get();

        return view('administrator.wilayah.province', compact(
            'province',
            'kab'
        ));
    }

    // Kecamatan berdasarkan kabupaten
    public function show($regencyCode)
    {
        $regency = Regency::where('code', $regencyCode)
            ->firstOrFail();

        $kec = District::where('regency_code', $regencyCode)
            ->orderBy('code')
            ->get();

        return view('administrator.wilayah.show', compact(
            'regency',
            'kec'
        ));
    }

    // Desa berdasarkan kecamatan
    public function detailshow($districtCode)
    {
        $district = District::where('code', $districtCode)
            ->firstOrFail();

        $regency = Regency::where('code', $district->regency_code)
            ->first();

        $desa = Village::where('district_code', $districtCode)
            ->orderBy('code')
            ->get();

        return view('administrator.wilayah.detailshow', compact(
            'district',
            'regency',
            'desa'
        ));
    }
}
