<?php

namespace App\Http\Controllers;

use App\Models\Tontine;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        $gestionnaires = User::where('profil', 'GERANT')->get();
        return view('pages.admin.gestionnaires', compact('gestionnaires'));
    }

    public function show($id)
{
    $gestionnaire = User::findOrFail($id);

    // Tontines assignées à ce gestionnaire
    $tontinesAttribuees = Tontine::where('user_id', $id)->get();

    // Tontines non assignées (libres)
    $tontinesLibres = Tontine::whereNull('user_id')->get();

    return view('pages.admin.gestionnaire-detail', compact('gestionnaire', 'tontinesAttribuees', 'tontinesLibres'));
}



    


public function loadSection($section)
{
    $views = [
        'gestionnaires' => 'pages.admin.sections.gestionnaires',
        'membres' => 'pages.admin.sections.membres',
        'creer-tontine' => 'pages.admin.sections.creer-tontine',
        'liste-tontines' => 'pages.admin.sections.liste-tontines',
    ];

    if (!array_key_exists($section, $views)) {
        return response('<p class="text-danger">Section introuvable.</p>', 404);
    }

    return view($views[$section]);
}





public function gestionnaires()
{
    $gestionnaires = User::where('profil', 'GERANT')->get();
    return view('pages.admin.gestionnaires', compact('gestionnaires'));


}

public function ajouterGestionnaire(Request $request)
{
    $request->validate([
        'prenom' => 'required|string',
        'nom' => 'required|string',
        'telephone' => 'required|string|unique:users,telephone',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    User::create([
        'prenom' => $request->prenom,
        'nom' => $request->nom,
        'telephone' => $request->telephone,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'profil' => 'GERANT',
    ]);

    return redirect()->route('admin.gestionnaires')->with('success', 'Gestionnaire ajouté avec succès !');
}

public function assignerTontine($userId, $tontineId)
{
    $tontine = Tontine::findOrFail($tontineId);
    $tontine->user_id = $userId;
    $tontine->save();

    return redirect()->back()->with('success', 'Tontine assignée avec succès au gestionnaire.');
}


// Afficher le formulaire de modification
public function edit($id)
{
    $user = User::findOrFail($id);
    return view('pages.admin.edit', compact('user'));
}

// Mettre à jour un gestionnaire
public function update(Request $request, $id)
{
    $request->validate([
        'prenom' => 'required',
        'nom' => 'required',
        'telephone' => 'required',
        'email' => 'required|email',
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'prenom' => $request->prenom,
        'nom' => $request->nom,
        'telephone' => $request->telephone,
        'email' => $request->email,
    ]);

    return redirect()->route('admin.gestionnaires')->with('success', 'Gestionnaire modifié avec succès.');
}

// Supprimer un gestionnaire
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.gestionnaires')->with('success', 'Gestionnaire supprimé avec succès.');
}

public function retirerTontine($userId, $tontineId)
{
    $tontine = \App\Models\Tontine::findOrFail($tontineId);

    // Vérifie que la tontine est bien assignée au bon gestionnaire
    if ($tontine->user_id == $userId) {
        $tontine->user_id = null;
        $tontine->save();
        return back()->with('success', 'Tontine retirée du gestionnaire avec succès.');
    }

    return back()->with('error', 'Erreur : cette tontine ne correspond pas à ce gestionnaire.');
}


}