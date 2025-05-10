@extends('layouts.gerant')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">📦 Détails de la Tontine</h3>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="text-dark fw-bold">{{ $tontine->libelle }}</h4>

            <p><strong>Fréquence :</strong> {{ ucfirst($tontine->frequence) }}</p>
            <p><strong>Durée :</strong> {{ $tontine->dateDebut }} → {{ $tontine->dateFin }}</p>
            <p><strong>Montant par personne :</strong> {{ number_format($tontine->montant_de_base) }} FCFA</p>
            <p><strong>Participants :</strong> {{ $tontine->participants->count() }} / {{ $tontine->nbreParticipant }}</p>

            <p>
                <strong>Inscription :</strong>
                <form action="{{ route('admin.tontines.toggle-inscription', $tontine->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $tontine->inscription_ouverte ? 'btn-outline-success' : 'btn-outline-danger' }}">

                        <i class="fas fa-circle {{ $tontine->inscription_ouverte ? 'text-success' : 'text-danger' }}"></i>

                        {{ $tontine->inscription_ouverte ? 'Ouvert' : 'Fermé' }}
                    </button>
                </form>         
            </p>

            <p><strong>Créée le :</strong> {{ $tontine->created_at->format('d/m/Y') }}</p>

            <div class="d-flex flex-wrap gap-2 mt-3">
                {{-- <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ajouterParticipantModal">
                    <i class="fas fa-user-plus"></i> Ajouter un participant
                </button> --}}

                <a href="#" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-money-bill-wave"></i> Cotisations
                </a>

                <a href="#" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-random"></i> Tirage
                </a>
            </div>
        </div>
    </div>

    <h4 class="mt-5 text-primary">👥 Participants</h4>

    @if($tontine->participants->isEmpty())
        <div class="alert alert-info">Aucun participant pour cette tontine.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tontine->participants as $participant)
                        <tr>
                            <td>{{ $participant->user->prenom }} {{ $participant->user->nom }}</td>
                            <td>{{ $participant->user->email }}</td>
                            <td>{{ $participant->user->telephone }}</td>
                            <td>
                                 <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#cotisations-{{ $participant->id }}">
                                     Détails
                                 </button>
                            </td>
                        </tr>
                        <tr class="collapse bg-light" id="cotisations-{{ $participant->id }}">
                            <td colspan="4">
                                <h6 class="text-primary">Cotisations de {{ $participant->user->prenom }} {{ $participant->user->nom }}</h6>

                                @php
                                    $dateDebut = \Carbon\Carbon::parse($tontine->dateDebut);
                                    $dateFin = \Carbon\Carbon::parse($tontine->dateFin);
                                    $frequence = strtoupper($tontine->frequence);
                                    $dateActuelle = $dateDebut->copy();
                                    $today = \Carbon\Carbon::today();

                                    $rows = [];
                                    while ($dateActuelle <= $dateFin) {
                                        $isPayee = \App\Models\Cotisation::where('idUser', $participant->user_id)
                                            ->where('idTontine', $tontine->id)
                                            ->whereDate('date_echeance', $dateActuelle)
                                            ->exists();

                                        $statut = $isPayee ? 'Déjà payée'
                                            : ($dateActuelle->isSameDay($today) ? 'À payer aujourd’hui'
                                            : ($dateActuelle->isFuture() ? 'À venir' : 'Retard'));

                                        $rows[] = [
                                            'date' => $dateActuelle->format('d/m/Y'),
                                            'statut' => $statut,
                                            'montant' => $tontine->montant_de_base
                                        ];

                                        match ($frequence) {
                                            'JOURNALIERE' => $dateActuelle->addDay(),
                                            'HEBDOMADAIRE' => $dateActuelle->addWeek(),
                                            'MENSUELLE' => $dateActuelle->addMonth(),
                                            default => throw new Exception("Fréquence invalide")
                                        };
                                    }
                                @endphp

                                <table class="table table-sm table-bordered mt-3">
                                    <thead class="table-secondary text-center">
                                        <tr>
                                            <th>Date échéance</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($rows as $r)
                                            <tr>
                                                <td>{{ $r['date'] }}</td>
                                                <td>{{ number_format($r['montant'], 0, ',', ' ') }} FCFA</td>
                                                <td>
                                                    <span class="badge
                                                        @if($r['statut'] === 'Déjà payée') bg-success
                                                        @elseif($r['statut'] === 'À payer aujourd’hui') bg-warning text-dark
                                                        @elseif($r['statut'] === 'Retard') bg-danger
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ $r['statut'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection