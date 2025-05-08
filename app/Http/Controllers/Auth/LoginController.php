<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Arahkan user setelah login berdasarkan role.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return '/admin/admin';
        } elseif ($user->role === 'member') {
            return '/home';
        }

        return '/';
    }

    /**
     * Middleware guest untuk halaman login,
     * kecuali logout yang butuh auth.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Setelah logout, arahkan ke halaman welcome.
     */
    public function loggedOut(Request $request)
    {
        return redirect('/');
    }
}
