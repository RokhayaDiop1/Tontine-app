<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use App\Models\Tontine;
use App\Models\User;
use Carbon\Carbon;
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
        $tontine = Tontine::findOrFail($request->tontine_id);

        // Vérifie si le nombre de participants est déjà atteint
        $nbParticipantsActuels = Participant::where('tontine_id', $tontine->id)->count();
        if ($nbParticipantsActuels >= $tontine->nbreParticipant) {
            return back()->with('error', 'Le nombre maximal de participants a déjà été atteint pour cette tontine.');
        }


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

    // Vérifie si la tontine peut être démarrée
        if ($nbParticipantsActuels + 1 == $tontine->nbreParticipant) {
            $tontine->update([
                'dateDebut' => now(), // ou garder la date initialement définie
            ]);

            // Tu peux aussi ajouter un champ `status` si tu veux indiquer que la tontine est "active"
            // $tontine->update(['status' => 'active']);
            if ($nbParticipantsActuels + 1 == $tontine->nbreParticipant) {
                $tontine->update([
                    'dateDebut' => now(),
                    'status' => 'active'
                ]);
            }
            
        }


    }

    

    public function calendrier($tontineId)
{
    $tontine = Tontine::findOrFail($tontineId);

    $echeances = $this->genererEcheances(
        $tontine->dateDebut,
        $tontine->dateFin,
        $tontine->frequence
    );

    return view('gerant.cotisations.calendrier', compact('tontine', 'echeances'));
}

private function genererEcheances($dateDebut, $dateFin, $frequence)
{
    $debut = \Carbon\Carbon::parse($dateDebut);
    $fin = \Carbon\Carbon::parse($dateFin);
    $echeances = collect();

    while ($debut <= $fin) {
        $echeances->push($debut->copy());

        match ($frequence) {
            'JOURNALIER' => $debut->addDay(),
            'HEBDOMADAIRE' => $debut->addWeek(),
            'MENSUEL' => $debut->addMonth(),
            default => null
        };
    }

    return $echeances;
}

// public function cotisations()
// {
//     $user = Auth::user();
//     $participants = Participant::with('tontine')
//         ->where('user_id', $user->id)
//         ->get();

//     $cotisations = [];

//     foreach ($participants as $participant) {
//         $tontine = $participant->tontine;
//         if (!$tontine) continue;

//         $frequence = $tontine->frequence;
//         $dateDebut = Carbon::parse($tontine->dateDebut);
//         $now = Carbon::now();

//         $diff = match ($frequence) {
//             'quotidienne' => $now->diffInDays($dateDebut),
//             'hebdomadaire' => floor($now->diffInWeeks($dateDebut)),
//             'mensuelle' => floor($now->diffInMonths($dateDebut)),
//             default => 0
//         };

//         $prochaineDate = match ($frequence) {
//             'quotidienne' => $dateDebut->copy()->addDays($diff + 1),
//             'hebdomadaire' => $dateDebut->copy()->addWeeks($diff + 1),
//             'mensuelle' => $dateDebut->copy()->addMonths($diff + 1),
//             default => $dateDebut
//         };

//         $cotisations[] = [
//             'tontine' => $tontine,
//             'prochaine_cotisation' => $prochaineDate->toDateString(),
//             'montant' => $tontine->montant_de_base,
//             'statut' => $now->toDateString() === $prochaineDate->toDateString() ? 'À payer' : 'À venir'
//         ];
//     }

//     return view('pages.participant.cotisations', compact('cotisations'));
// }

    

}
