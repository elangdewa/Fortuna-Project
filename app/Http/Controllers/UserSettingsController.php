<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserSettingsController extends Controller
{
    public function index()
    {
        return view('user.setting', [
            'user' => Auth::user()
        ]);
    }

   public function updateProfile(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'phone', 'address']);

    if ($request->hasFile('profile_photo')) {
        // Hapus foto lama jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete('profile_photos/' . $user->profile_photo);
        }

        // Simpan foto baru
        $filename = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
        $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public'); // Menyimpan di disk 'public'
        $data['profile_photo'] = $filename;
    }

    $user->update($data);

    return back()->with('success', 'Profil berhasil diperbarui');
}

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Password saat ini salah');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('password_success', 'Password berhasil diubah');
    }
}
