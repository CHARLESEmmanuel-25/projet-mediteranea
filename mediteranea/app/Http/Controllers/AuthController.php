<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Affiche la page d'inscription.
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Gère l'inscription d'un utilisateur.
     */


     public function storeRegister(Request $request)
     {
         Log::info('Début du storeRegister', ['data' => $request->all()]);

         $request->validate([
             'fullname' => 'required|string',
             'email' => 'required|email|unique:users,email',
             'phone' => 'required|string',
             'password' => 'required|string',
         ]);

         Log::info('Validation réussie');

         try {
             // Générer un token unique
             $token = Str::random(32);

             // Stocker les informations en session (pas encore en base)
             session([
                 'user' => [
                     'name' => $request->fullname,
                     'email' => $request->email,
                     'phone' => $request->phone,
                     'password' => Hash::make($request->password),
                 ],
                 'confirmation_token' => $token,
             ]);

             // Lien de confirmation
             $confirmationLink = route('confirm.register', ['token' => $token]);

             // Envoi du mail avec le lien
             Mail::to($request->email)->send(new SignUp($request, $confirmationLink));

             Log::info('Mail envoyé avec succès à ' . $request->email);

             return redirect()->route('show.login')->with('success', 'Un email de confirmation vous a été envoyé.');
         } catch (\Exception $e) {
             Log::error('Erreur lors de l’envoi du mail : ' . $e->getMessage());
             return redirect()->back()->withInput()->with('error', 'Erreur lors de l’envoi de l’email.');
         }
     }



     public function confirmRegister($token)
     {
         // Vérifier si le token correspond
         if (session('confirmation_token') !== $token) {
             return redirect()->route('show.login')->with('error', 'Lien invalide ou expiré.');
         }

         // Récupérer les données utilisateur stockées en session
         $userData = session('user');

         if (!$userData) {
             return redirect()->route('show.login')->with('error', 'Session expirée. Veuillez recommencer.');
         }

         // Enregistrer l'utilisateur en base
         $user = User::create($userData);

         // Supprimer les données de session
         session()->forget(['user', 'confirmation_token']);

         return redirect()->route('show.login')->with('success', 'Votre inscription est confirmée. Vous pouvez vous connecter.');
     }





    /**
     * Affiche la page de connexion.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Gère la connexion d'un utilisateur.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Authentification réussie, rediriger vers la page d'accueil ou tableau de bord
            return redirect()->route('home')->with('success', 'Connexion réussie !');
        }

        // Authentification échouée, rediriger avec un message d'erreur
        return redirect()->back()->withInput()->with('error', 'Identifiants invalides.');
    }

    public function invoke(Request $request)
    {
        Auth::logout(); // Déconnecte l'utilisateur

        $request->session()->invalidate(); // Invalide la session
        $request->session()->regenerateToken(); // Régénère le token CSRF

        return redirect()->route('show.login')->with('success', 'Votre session a bien été fermé');
    }
}
