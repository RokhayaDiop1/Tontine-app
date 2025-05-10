<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Tontine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotisationController extends Controller
{
    /**
     * Affiche les cotisations à faire pour une tontine donnée.
     */
   public function voirCotisations($id)
{
    $user = Auth::user();
    $tontine = Tontine::findOrFail($id);

    $dateDebut = Carbon::parse($tontine->dateDebut);
    $dateFin = Carbon::parse($tontine->dateFin);
    $frequence = strtoupper($tontine->frequence);

    $echeances = [];
    $dateActuelle = $dateDebut->copy();
    $aujourdhui = Carbon::today();

    while ($dateActuelle <= $dateFin) {
        $isPayee = Cotisation::where('idUser', $user->id)
            ->where('idTontine', $tontine->id)
            ->whereDate('date_echeance', $dateActuelle)
            ->where('statut', 'payee')
            ->exists();

        $statut = match (true) {
            $isPayee => 'Déjà payée',
            $dateActuelle->isSameDay($aujourdhui) => 'À payer aujourd’hui',
            $dateActuelle->isFuture() => 'À venir',
            default => 'Retard'
        };

        $echeances[] = [
            'date' => $dateActuelle->format('Y-m-d'),
            'montant' => $tontine->montant_de_base,
            'statut' => $statut,
        ];

        match ($frequence) {
            'JOURNALIERE' => $dateActuelle->addDay(),
            'HEBDOMADAIRE' => $dateActuelle->addWeek(),
            'MENSUELLE' => $dateActuelle->addMonth(),
            default => throw new \Exception("Fréquence inconnue : $frequence"),
        };
    }

    return view('pages.participant.cotisations_par_tontine', compact('tontine', 'echeances'));
}

public function store(Request $request)
{
    $request->validate([
        'tontine_id' => 'required|exists:tontines,id',
        'date_echeance' => 'required|date',
        'montant' => 'required|numeric|min:100',
        'moyen_paiement' => 'required|in:OM,WAVE',
    ]);

    //  dd($request->all());

    Cotisation::create([
    'idUser' => Auth::id(),
    'idTontine' => $request->tontine_id,
    'date_echeance' => $request->date_echeance, // ⬅️ TRÈS IMPORTANT
    'montant' => $request->montant,
    'moyen_paiement' => $request->moyen_paiement,
    'statut' => 'payee',
]);


    return redirect()->back()->with('success', '✅ Paiement effectué avec succès !');
}


public function historique()
{
    $userId = Auth::id();
    $cotisations = Cotisation::with('tontine')
        ->where('idUser', $userId)
        ->orderBy('date_echeance', 'desc')
        ->get();

    return view('pages.participant.cotisation_historique', compact('cotisations'));
}


public function cotisationsParticipant($tontineId, $participantId)
{
    $tontine = Tontine::findOrFail($tontineId);
    $participant = \App\Models\Participant::with('user')->findOrFail($participantId);
    $user = $participant->user;

    $dateDebut = Carbon::parse($tontine->dateDebut);
    $dateFin = Carbon::parse($tontine->dateFin);
    $frequence = strtoupper($tontine->frequence);
    $aujourdhui = Carbon::today();

    $echeances = [];
    $dateActuelle = $dateDebut->copy();

    while ($dateActuelle <= $dateFin) {
        $isPayee = Cotisation::where('idUser', $user->id)
            ->where('idTontine', $tontine->id)
            ->whereDate('date_echeance', $dateActuelle)
            ->exists();

        $statut = match (true) {
            $isPayee => 'Déjà payée',
            $dateActuelle->isSameDay($aujourdhui) => 'À payer aujourd’hui',
            $dateActuelle->isFuture() => 'À venir',
            default => 'Retard',
        };

        $echeances[] = [
            'date' => $dateActuelle->format('Y-m-d'),
            'montant' => $tontine->montant_de_base,
            'statut' => $statut,
        ];

        match ($frequence) {
            'JOURNALIERE' => $dateActuelle->addDay(),
            'HEBDOMADAIRE' => $dateActuelle->addWeek(),
            'MENSUELLE' => $dateActuelle->addMonth(),
            default => throw new \Exception("Fréquence inconnue : $frequence"),
        };
    }

    return view('gerant.participant_cotisations', compact('participant', 'tontine', 'echeances'));
}

}