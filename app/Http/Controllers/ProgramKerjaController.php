<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use App\Http\Requests\StoreProgramKerjaRequest;
use App\Http\Requests\UpdateProgramKerjaRequest;
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $data = ProgramKerja::when($q, fn($query) => $query->search($q))
            ->orderBy('nomor')
            ->paginate(10)
            ->withQueryString();

        return view('program-kerja.index', compact('data', 'q'));
    }

    public function create()
    {
        $opsiWaktu = ['bulanan', 'triwulan', 'semester', 'tahunan'];
        return view('program-kerja.create', compact('opsiWaktu'));
    }

    public function store(StoreProgramKerjaRequest $request)
    {
        ProgramKerja::create($request->validated());
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    public function show(ProgramKerja $program_kerja)
    {
        return view('program-kerja.show', compact('program_kerja'));
    }

    public function edit(ProgramKerja $program_kerja)
    {
        $opsiWaktu = ['bulanan', 'triwulan', 'semester', 'tahunan'];
        return view('program-kerja.edit', compact('program_kerja', 'opsiWaktu'));
    }

    public function update(UpdateProgramKerjaRequest $request, ProgramKerja $program_kerja)
    {
        $program_kerja->update($request->validated());
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil diperbarui.');
    }

    public function destroy(ProgramKerja $program_kerja)
    {
        $program_kerja->delete();
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil dihapus.');
    }
}
