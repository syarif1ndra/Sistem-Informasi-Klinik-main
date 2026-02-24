<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApotekerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isApoteker()) {
            // Not a pharmacist -> redirect to home/dashboard based on role 
            // Instead of 403, we often just redirect to the correct dashboard using the typical redirector logic
            // or simply abort 403.
            abort(403, 'Akses ditolak. Halaman ini khusus Apoteker.');
        }

        return $next($request);
    }
}
