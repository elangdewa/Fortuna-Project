<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan halaman profil admin
    public function show()
    {
        /** @var User $user */
        $user = Auth::user(); // Intelephense tahu sekarang $user adalah model User

        return view('admin.profile', compact('user'));
    }

    // Memperbarui nama pengguna
    public function updateUsername(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user(); // Tambah tipe agar Intelephense tidak error
        $user->update(['name' => $request->name]); // Intelephense kini mengenali metode update()

        return redirect()->route('admin.profile')->with('success', 'Nama pengguna berhasil diperbarui.');
    }

    // Memperbarui password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Password saat ini salah.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('password_success', 'Password berhasil diperbarui.');
    }
}
