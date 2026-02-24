<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        Auth::logoutOtherDevices($request->string('password'));

        if ($request->user()->isAdmin()) {
            \Illuminate\Support\Facades\Log::info("Admin login");
            return redirect()->route('admin.dashboard');
        } elseif ($request->user()->isBidan()) {
            \Illuminate\Support\Facades\Log::info("Bidan login");
            return redirect()->route('bidan.dashboard');
        } elseif ($request->user()->isDokter()) {
            \Illuminate\Support\Facades\Log::info("Dokter login attempt redirecting to: " . route('dokter.dashboard'));
            return redirect()->route('dokter.dashboard');
        } elseif ($request->user()->isOwner()) {
            \Illuminate\Support\Facades\Log::info("Owner login");
            return redirect()->route('owner.dashboard');
        } elseif ($request->user()->isApoteker()) {
            \Illuminate\Support\Facades\Log::info("Apoteker login");
            return redirect()->route('apoteker.dashboard');
        }

        \Illuminate\Support\Facades\Log::info("User login role: " . $request->user()->role);
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
