<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google’s OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            // Récupération des informations de l'utilisateur depuis Google
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('show.login')->with('error', 'La connexion avec Google a échoué.');
        }

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Création d'un nouvel utilisateur
            $user = new User([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)), // Mot de passe aléatoire
                'email_verified_at' => now(),
            ]);

            $user->save(); // Enregistrement dans la base de données
        }

        // Connexion de l'utilisateur
        Auth::login($user);
        session()->regenerate(); // Sécurisation de la session

        // Redirection vers la page d'accueil ou tableau de bord
        return redirect()->route('home')->with('success', 'Connexion réussie !');
    }
}
