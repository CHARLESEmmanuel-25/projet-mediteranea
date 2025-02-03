<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        // La validation des données est assurée en front, mais il est préférable de la refaire en back-end pour éviter toute faille
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        // Création de l'utilisateur
        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            // Gestion des notifications pour informer de la réussite de l'inscription
            return redirect()->route('show.login')->with('success', 'Inscription réussie !');
        }

        return redirect()->route('show.registration')->with('error', 'Erreur lors de la création du compte.');
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
    public function storeLogin(Request $request)
    {
        // Implémentation à ajouter
    }
}
