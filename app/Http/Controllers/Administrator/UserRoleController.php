<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    

    public function index()
    {
        $users = User::with(['roles', 'province', 'regency'])
            ->latest()
            ->get();

        return view('administrator.users.index', compact('users'));
    }

    public function create()
    {
        return view('administrator.users.create');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'code' => ['required', 'string', 'max:20'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return back()->with('success', 'User berhasil dibuat.');
    }

    public function assignRole(User $user)
    {
        $roles = Role::select('id', 'name')->get();

        return view('administrator.users.assign-role', compact('user', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user->syncRoles($data['role']);

        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::with([
            'province',
            'regency',
            'district',
            'village'
        ])
            ->where('email', $request->email)
            ->firstOrFail();

        $newPassword = Str::random(8);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // Tentukan wilayah user yang di-reset
        $wilayah = 'Tidak diketahui';

        if ($user->regency?->name) {
            $wilayah = Str::startsWith(
                $user->regency->name,
                'Kab.'
            )
                ? 'Kabupaten ' . substr($user->regency->name, 4)
                : $user->regency->name;
        } elseif ($user->district?->name) {
            $wilayah = 'Kec. ' . $user->district->name;
        } elseif ($user->village?->name) {
            $wilayah = $user->village->name;
        } elseif ($user->province?->name) {
            $wilayah = $user->province->name;
        }

        return back()->with(
            'reset_password_success',
            [
                'email' => $user->email,
                'password' => $newPassword,
                'wilayah' => $wilayah,
            ]
        );
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->syncRoles([]);
        $user->syncPermissions([]);
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function removeRolePermission(User $user)
    {
        $user->syncRoles([]);
        $user->syncPermissions([]);

        return back()->with('success', 'Role & permission dihapus.');
    }
    public function changeRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        // replace semua role lama
        $user->syncRoles([$data['role']]);

        return back()->with('success', 'Role user berhasil diubah.');
    }
    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();

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
