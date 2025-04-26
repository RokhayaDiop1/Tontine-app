<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\User;


class ParticipantController extends Controller
{
    public function index()
{
    return view('pages.participant.dashboard');
}



public function ajouterParticipant(Request $request)
{
    $validated = $request->validate([
        'user_id'       => 'required|exists:users,id',
        'tontine_id'    => 'required|exists:tontines,id',
        'dateNaissance' => 'required|date',
        'cni'           => 'required|string|size:13|unique:participants,cni',
        'adresse'       => 'required|string',
        'imageCni'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Si une image est envoyée
    if ($request->hasFile('imageCni')) {
        $imagePath = $request->file('imageCni')->store('cni_images', 'public');
        $validated['imageCni'] = $imagePath;
    }

    // Création du participant
    Participant::create($validated);

    return back()->with('success', 'Participant ajouté avec succès.');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'tontine_id' => 'required|exists:tontines,id',
        'dateNaissance' => 'required|date',
        'cni' => 'required|string|unique:participants,cni',
        'adresse' => 'required|string',
        'imageCni' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('imageCni')) {
        $validated['imageCni'] = $request->file('imageCni')->store('cni_images', 'public');
    }

    Participant::create($validated);

    return back()->with('success', 'Participant ajouté avec succès.');
}




public function create()
{
    $users = User::where('profil', 'PARTICIPANT')->get(); // ou sans filtre selon ton besoin
    return view('participants.create', compact('users'));
}


}
