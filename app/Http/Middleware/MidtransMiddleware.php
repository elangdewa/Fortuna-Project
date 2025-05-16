<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MidtransMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('payments/callback')) {
            // You can add Midtrans signature verification here if needed
            return $next($request);
        }

        return $next($request);
    }
}
