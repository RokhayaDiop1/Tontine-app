<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    // Affiche la vue d'inscription
    public function index()
    {
        return view('pages.inscription.index');
    }

    // Traite le formulaire d'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'prenom'         => 'required|string|min:3',
            'nom'            => 'required|string|min:2',
            'email'          => 'required|email|unique:users,email',
            'telephone'      => 'required|digits:9|unique:users,telephone',
            'dateNaissance'  => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'cni'            => 'required|digits:13|unique:participants,cni',
            'adresse'        => 'required|string',
            'password'       => 'required|string|min:6|confirmed',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'prenom'    => $validated['prenom'],
            'nom'       => $validated['nom'],
            'email'     => $validated['email'],
            'telephone' => $validated['telephone'],
            'password'  => Hash::make($validated['password']),
            'profil'    => 'PARTICIPANT',
        ]);

        if ($user) {
            // Création du participant lié à l'utilisateur
            Participant::create([
                'idUser'        => $user->id,
                'dateNaissance' => $validated['dateNaissance'],
                'cni'           => $validated['cni'],
                'adresse'       => $validated['adresse'],
            ]);

            return redirect()->route('auth.create')->with('success', 'Inscription réussie. Connectez-vous maintenant.');
        }

        return back()->with('error', "Une erreur s'est produite. Veuillez réessayer.");
    }

    public function home()
    {
        return view('welcome');
    }
}
