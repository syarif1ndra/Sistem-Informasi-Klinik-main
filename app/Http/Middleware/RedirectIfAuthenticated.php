<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($request->user()->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($request->user()->isBidan()) {
                    return redirect()->route('bidan.dashboard');
                } elseif ($request->user()->isDokter()) {
                    return redirect()->route('dokter.dashboard');
                } elseif ($request->user()->isOwner()) {
                    return redirect()->route('owner.dashboard');
                }
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
