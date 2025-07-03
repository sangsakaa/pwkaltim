<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles','province', 'regency')
            ->get();

        return view('administrator.users.index', compact('users'));
    }
    public function create()
    {
        return view('administrator.users.create');
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'code' => 'required|string|unique:users,code|max:20', // tambahkan ini
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'code' => $request->code, // tambahkan ini
        ]);

        return redirect()->back()->with('success', 'User berhasil dibuat.');
    }
    public function assignRole(User $user)
    {
        $roles = Role::all();
        return view('administrator.users.assign-role', compact('user', 'roles'));
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('administrator.users.assign-role', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]); // Ganti role lama dengan yang baru
        return redirect()->back()->with('success', 'Role berhasil diperbarui.');
    }
}
