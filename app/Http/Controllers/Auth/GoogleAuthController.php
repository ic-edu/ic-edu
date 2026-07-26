<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists based on google_id or email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Update google_id if it's missing (e.g., they registered via email first)
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'profile_photo' => $user->profile_photo ?? $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Create a new user if not exists
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'profile_photo' => $googleUser->getAvatar(),
                    'role' => 'test_taker', // Default role for new signups
                    'password' => bcrypt(\Illuminate\Support\Str::random(16)), // Random password, they use Google to login
                    'email_verified_at' => now(), // Assume Google emails are verified
                    'tokens' => 0,
                ]);
            }

            // Log the user in
            Auth::login($user, true);

            // Redirect to intended page or dashboard
            return redirect()->intended(route('dashboard'));

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Sesi login telah kedaluwarsa. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to authenticate with Google. Please try again.');
        }
    }
}
