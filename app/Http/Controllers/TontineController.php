<?php

namespace App\Http\Controllers;

use App\Models\Tontine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TontineController extends Controller
{
    // Affiche le formulaire de création de tontine
    public function create()
    {
        $gerants = User::where('profil', 'GERANT')->get();
        return view('pages.admin.creer-tontine', compact('gerants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'frequence' => 'required|in:JOURNALIERE,HEBDOMADAIRE,MENSUELLE',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'description' => 'required|string',
            'montant_de_base' => 'required|numeric|min:0',
            'montant_total' => 'required|numeric|min:0',
            'nbreParticipant' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
            'inscription_ouvert' => 'required|in:ouvert,fermer',
        ]);
    
        Tontine::create($validated);

       
    
        return redirect()->route('admin.liste-tontines')->with('success', 'Tontine créée avec succès.');
    }
    

    // public function index()
    // {
    //     $tontines = Tontine::where('user_id', Auth::id())->get();
    //     return view('pages.gerant.tontines', compact('tontines'));
    // }
    
     // Liste des tontines
     public function index()
     {
         $tontines = Tontine::with('gerant')->get()->map(function ($tontine) {
             $tontine->ouvert = $tontine->inscription_ouvert === 'ouvert';
             return $tontine;
         });
     
         return view('pages.admin.liste-tontines', compact('tontines'));
     }
     
     public function show($id)
     {
         $tontine = Tontine::withCount('participants')->findOrFail($id);
         return view('pages.gerant.tontine-detail', compact('tontine'));
     }
     

//     public function tontinesDuGerant()
// {
//     $tontines = Tontine::where('user_id', Auth::id())->get();
//     return view('pages.gerant.tontines', compact('tontines'));
// }



public function tontinesDuGerant()
{
    $tontines = Tontine::withCount('participants')
                ->where('user_id', Auth::id())
                ->get();

    return view('pages.gerant.tontines', compact('tontines'));
}

public function toggleInscription($id)
{
    $tontine = Tontine::findOrFail($id);

    // Nombre de participants actuels (tu peux définir cette relation dans le modèle Tontine)
    $nbActuels = $tontine->participants()->count();

    // Vérifie si la tontine est pleine
    if ($nbActuels >= $tontine->nbreParticipant) {
        return back()->with('error', '❌ Impossible d’ouvrir l’inscription : la tontine est déjà pleine.');
    }

    // Bascule de l'état ouvert <-> fermé
    $tontine->inscription_ouverte = !$tontine->inscription_ouverte;
    $tontine->save();

    return back()->with('success', '✅ État de l’inscription mis à jour avec succès.');
}


public function edit($id)
{
    $tontine = Tontine::findOrFail($id);
    $gerants = User::where('profil', 'GERANT')->get();
    return view('pages.admin.edit-tontine', compact('tontine', 'gerants'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'libelle' => 'required|string|max:255',
        'frequence' => 'required|in:HEBDOMADAIRE,MENSUELLE',
        'dateDebut' => 'required|date',
        'dateFin' => 'required|date|after_or_equal:dateDebut',
        'description' => 'required|string',
        'montant_de_base' => 'required|numeric',
        'montant_total' => 'required|numeric',
        'nbreParticipant' => 'required|integer',
        'user_id' => 'nullable|exists:users,id',
    ]);

    $tontine = Tontine::findOrFail($id);
    $tontine->update($validated);

    return redirect()->route('admin.liste-tontines')->with('success', 'Tontine modifiée avec succès.');
}

public function destroy($id)
{
    $tontine = Tontine::findOrFail($id);
    $tontine->delete();

    return redirect()->route('admin.liste-tontines')->with('success', 'Tontine supprimée avec succès.');
}



}