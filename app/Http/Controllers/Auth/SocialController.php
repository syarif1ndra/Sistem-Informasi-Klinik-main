<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Check if user is admin
                if ($user->role === 'admin') {
                    return redirect()->route('user.login')->withErrors(['email' => 'Access denied. Admins cannot login via Google.']);
                }

                // Update google_id if not set
                if (empty($user->google_id)) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }

                Auth::login($user);

                return redirect()->route('dashboard');
            } else {
                // Create new user
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'user', // Default role
                    'password' => Hash::make(Str::random(16)), // Dummy password
                    'email_verified_at' => now(), // Auto verify email
                ]);

                Auth::login($newUser);

                return redirect()->route('dashboard');
            }

        } catch (\Exception $e) {
            return redirect()->route('user.login')->withErrors(['email' => 'Login with Google failed. Please try again. ' . $e->getMessage()]);
        }
    }
}
