<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departemens = Departemen::latest()->paginate(10);
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Departemen::create($request->only('name'));

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil ditambahkan');
    }

    public function show(Departemen $departemen)
    {
        return view('departemen.show', compact('departemen'));
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $departemen->update(['name' => $request->name]);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus');
    }
}
