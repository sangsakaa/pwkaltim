<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prov = Province::where('code', 64)->get();
        $kab = Regency::where('province_code', 64)->orderby('code')->get();
        $kec = District::all();




        return view('administrator.wilayah.index', compact('prov', 'kab', 'kec'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($regency)
    {
        $kec = District::where('regency_code', $regency)->orderby('code')->get();
        return view('administrator.wilayah.show', compact('regency','kec'));
    }
    public function detailshow($regency)
    {
        $desa = Village::where('district_code', $regency)->orderby('code')->get();
        return view('administrator.wilayah.detailshow', compact('regency', 'desa'));
    }
    /**
     * Show the form for editing the specified resource.
     */
}
