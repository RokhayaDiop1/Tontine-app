<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Affiche le formulaire de connexion
    public function create()
    {
        return view('pages.auth.auth');
    }

    // Traite la soumission du formulaire de connexion
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $profil = Auth::user()->profil;

            switch ($profil) {
                case 'SUPER_ADMIN':
                    return redirect()->route('admin.dashboard');

                case 'GERANT':
                    return redirect()->route('gerant.dashboard');

                case 'PARTICIPANT':
                    return redirect()->route('participant.dashboard');

                default:
                    Auth::logout();
                    return redirect()->route('auth.create')->with('error', 'Profil non reconnu.');
            }
        }

        return back()->withErrors([
            'email' => "Les informations d'identification sont incorrectes.",
        ])->onlyInput('email');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.create');
    }
}
