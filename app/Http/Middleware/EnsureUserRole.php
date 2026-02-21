<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'user') {
            if ($request->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($request->user()->role === 'bidan') {
                return redirect()->route('bidan.dashboard');
            }
            return redirect('/');
        }

        return $next($request);
    }
}
