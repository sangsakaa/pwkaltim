<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prov = Province::where('code', 64)->get();
        $kab = Regency::where('province_code', 64)->get();
        $kec = District::where('regency_code', 64)->get();
        return view('administrator.wilayah.index', compact('prov', 'kab','kec'));
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
        $kec = District::where('regency_code', $regency)->get();
        return view('administrator.wilayah.show', compact('regency','kec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
