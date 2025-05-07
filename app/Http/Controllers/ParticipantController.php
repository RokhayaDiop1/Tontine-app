<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use App\Models\Tontine;
use App\Models\User;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    /**
     * Affiche le tableau de bord du participant avec ses tontines
     */
    public function dashboard()
{
    $user = Auth::user();

    // Récupère les participations
    $participants = Participant::with('tontine')
        ->where('user_id', $user->id)
        ->get();

    $mesTontines = $participants->pluck('tontine')->unique('id');

    // Toutes les tontines existantes
    $tontines = Tontine::all();

    return view('pages.participant.dashboard', compact('mesTontines', 'tontines'));
}


    /**
     * Affiche la liste des tontines auxquelles le participant est inscrit
     */
    public function mesTontines()
    {
        $userId = Auth::id();

        $participants = Participant::with('tontine')
            ->where('user_id', $userId)
            ->get();

        $tontines = $participants->pluck('tontine')->unique('id');

        return view('participant.tontines', compact('tontines'));
    }

    /**
     * Affiche la page avec toutes les tontines disponibles + celles auxquelles l'utilisateur participe
     */
    public function explorer()
    {
        $user = Auth::user();

        // Toutes les tontines disponibles
        $tontines = Tontine::all();

        // Tontines auxquelles l'utilisateur participe déjà
        $mesTontines = Participant::where('user_id', $user->id)
            ->with('tontine')
            ->get()
            ->pluck('tontine')
            ->unique('id');

        return view('pages.participant.dashboard', compact('tontines', 'mesTontines'));
    }

    /**
     * Affiche le formulaire d'adhésion à une tontine
     */
    public function create($tontine_id)
{
    $tontine = Tontine::findOrFail($tontine_id);
    $user = Auth::user();

    // Vérifier s’il existe déjà une participation de l’utilisateur
    $participant = Participant::where('user_id', $user->id)->first();

    return view('pages.participant.create', compact('tontine', 'user', 'participant'));
}


    /**
     * Enregistre la participation d'un utilisateur à une tontine
     */
    public function store(Request $request)
    {
        $request->validate([
            'tontine_id' => 'required|exists:tontines,id',
            'dateNaissance' => 'required|date',
            'cni' => 'required|string|max:50',
            'adresse' => 'required|string|max:255',
            'imageCni' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Vérifie s'il participe déjà à cette tontine
        $existe = Participant::where('user_id', $user->id)
            ->where('tontine_id', $request->tontine_id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Vous participez déjà à cette tontine.');
        }

        // Stockage de la pièce d'identité
        $imagePath = $request->file('imageCni')->store('cni_images', 'public');

        // Enregistrement de la participation
        Participant::create([
            'user_id' => $user->id,
            'tontine_id' => $request->tontine_id,
            'dateNaissance' => $request->dateNaissance,
            'cni' => $request->cni,
            'adresse' => $request->adresse,
            'imageCni' => $imagePath,
        ]);

        return redirect()->to(route('participant.dashboard') . '#section-mes-tontines')
    ->with('success', 'Participation enregistrée avec succès.');

    }

    

}
