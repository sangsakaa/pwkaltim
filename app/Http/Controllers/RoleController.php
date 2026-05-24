<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();

        return view('administrator.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('administrator.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['array']
        ]);

        $role = Role::create(['name' => $data['name']]);

        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('administrator.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:roles,name,' . $role->id],
            'permissions' => ['array']
        ]);

        $role->update(['name' => $data['name']]);

        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('success', 'Role berhasil dihapus.');
    }
}
