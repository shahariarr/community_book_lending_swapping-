<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists with this Google ID
            $existingUser = User::where('google_id', $googleUser->id)->first();

            if ($existingUser) {
                // Login existing user
                Auth::login($existingUser);
                return redirect()->route('dashboard')->with('success', 'Welcome back! You have been logged in via Google.');
            }

            // Check if user exists with same email
            $userWithEmail = User::where('email', $googleUser->email)->first();

            if ($userWithEmail) {
                // Link Google account to existing user
                $userWithEmail->update(['google_id' => $googleUser->id]);
                Auth::login($userWithEmail);
                return redirect()->route('dashboard')->with('success', 'Your Google account has been linked successfully!');
            }

            // Create new user
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make('password'), // Random password for social users
                'email_verified_at' => now(),
            ]);

            // Assign default role to new user
            $newUser->assignRole('User');

            Auth::login($newUser);

            return redirect()->route('dashboard')->with('success', 'Welcome! Your account has been created successfully via Google.');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong with Google authentication. Please try again.');
        }
    }
}
