<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

          if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return redirect()->route('user.home')
            ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
