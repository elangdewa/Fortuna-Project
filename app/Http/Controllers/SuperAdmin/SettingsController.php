<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('superadmin.settings');
    }

  public function update(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    if ($request->type === 'email') {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->email = $request->email;
        $user->save();

        return redirect()->route('superadmin.settings.index')->with('success', 'Email updated successfully.');
    }

    if ($request->type === 'password') {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('superadmin.settings.index')->with('success', 'Password updated successfully.');
    }

    return redirect()->route('superadmin.settings.index')->with('error', 'Invalid request.');
}
}
