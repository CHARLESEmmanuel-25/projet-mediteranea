<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'fullname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);

        Log::info('Validation réussie');

        // Création de l'utilisateur
        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            Log::info('Utilisateur créé avec succès', ['user_id' => $user->id]);
            session()->flash('success', 'Inscription réussie !');
            return redirect()->route('show.login');
        }

        Log::error('Erreur lors de la création de l’utilisateur');

        return redirect()->back()->withInput()->with('error', 'Erreur lors de la création du compte.');
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
