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
     * Handle successful authentication.
     */
    protected function authenticated(Request $request, $user)
    {
        
        $request->session()->regenerate();


        $request->session()->forget('url.intended');

        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard')->with('noback', true);
        } elseif ($user->role === 'admin') {
            return redirect('/admin/admin')->with('noback', true);
        } elseif ($user->role === 'member') {
            return redirect('/home')->with('noback', true);
        }

        return redirect('/');
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle logout redirection.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Prevent back button after logout
        return redirect('/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
