<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDokterRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isDokter()) {
            if ($request->user() && $request->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($request->user() && $request->user()->isBidan()) {
                return redirect()->route('bidan.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
