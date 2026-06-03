<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    /**
     * Edit profile user lain
     */
    public function editUser(User $user): View
    {
        abort_unless(
            auth()->user()->hasAnyRole([
                'superAdmin',
                'admin-provinsi'
            ]),
            403
        );

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update profile user lain
     */
    public function updateUser(
        Request $request,
        User $user
    ): RedirectResponse {

        abort_unless(
            auth()->user()->hasAnyRole([
                'superAdmin',
                'admin-provinsi'
            ]),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $user->update($validated);

        return back()->with(
            'success',
            'Data user berhasil diperbarui'
        );
    }
}
