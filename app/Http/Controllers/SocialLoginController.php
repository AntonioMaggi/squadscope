<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Credentials;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider(Request $request, $provider)
    {
        $credentials = Credentials::where('provider', $provider)->firstOrFail();

        $config = [
            'client_id' => $credentials->client_id,
            'client_secret' => $credentials->client_secret,
            'redirect' => $credentials->redirect,
        ];

        return Socialite::driver($provider)->setConfig($config)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            // Check if the user already exists
            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                // Log the user in
                Auth::login($existingUser);
                return redirect()->intended('/');
            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make('default_password'), // Consider generating a secure random password
                ]);

                // Save the credentials to the database
                $credentials = new Credentials;
                $credentials->provider = $provider;
                $credentials->client_id = $user->getId();
                $credentials->client_secret = ''; // You might not get the client secret from the user object
                $credentials->user_id = $newUser->id;
                $credentials->save();

                // Log the user in
                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            return redirect()->intended('/login')->with('error', 'Login failed!');
        }
    }
}
