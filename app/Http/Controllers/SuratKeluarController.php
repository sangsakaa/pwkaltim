<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat = SuratKeluar::latest()->paginate(10);
        return view('administrator.surat.keluar.index', compact('surat'));
    }

    public function create()
    {
        return view('administrator.surat.keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'perihal' => 'required',
            'kepada' => 'required',
            'isi_surat' => 'required',
        ]);

        SuratKeluar::create($request->all());

        return redirect()->with('success', 'Data surat berhasil disimpan.');
    }
}
