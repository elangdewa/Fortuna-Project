<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Nama pengguna berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ], [
        'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
    ]);
    
    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('password_error', 'Password saat ini salah.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('password_success', 'Password berhasil diperbarui.');
}

}
