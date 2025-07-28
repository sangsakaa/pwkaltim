<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole(['admin-provinsi', 'superAdmin'])) {
            abort(403, 'Unauthorized access.');
        }

        $users = User::with('roles', 'province', 'regency')->get();


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
            'code' => 'required|string|max:20', // tambahkan ini
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
    // RESET PASSWORD
    public function resetPassword(Request $request)
    {

        $user = User::where('email', $request->email)->firstOrFail();

        // Generate password baru
        $newPassword = Str::random(8);

        // Simpan hash ke database
        $user->password = Hash::make($newPassword);
        $user->save();

        // Kirim password baru kembali ke view (sekali tampil)
        return redirect()->back()->with('reset_password_success', [
            'email' => $user->email,
            'password' => $newPassword,
        ]);
    }


    public function destroy(User $user)
    {
        // Optional: Cegah user menghapus diri sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        // Hapus semua role dan permission
        $user->syncRoles([]);
        $user->syncPermissions([]);

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'User, role, dan permission berhasil dihapus.');
    }
    public function removeRolePermission($id)
    {
        $user = User::findOrFail($id);

        // Hapus semua role
        $user->syncRoles([]); // atau $user->roles()->detach();

        // Hapus semua permission langsung (jika ada permission langsung ke user, bukan melalui role)
        $user->syncPermissions([]); // atau $user->permissions()->detach();

        // Jangan hapus user-nya, cukup role dan permission saja

        return redirect()->back()->with('success', 'Role dan permission user berhasil dihapus.');
    }
}
