@extends('layouts.admin')

@section('contenu')
<div class="container mt-4">

    {{-- Titre principal --}}
    <h2 class="mb-4 text-primary">
        <i class="fas fa-user-tie"></i> Détails du Gestionnaire
    </h2>

    {{-- Carte infos gestionnaire --}}
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <h4 class="card-title text-dark">{{ $gestionnaire->prenom }} {{ $gestionnaire->nom }}</h4>
            <p><i class="fas fa-envelope"></i> <strong>Email :</strong> {{ $gestionnaire->email }}</p>
            <p><i class="fas fa-phone"></i> <strong>Téléphone :</strong> {{ $gestionnaire->telephone }}</p>
            <p><i class="fas fa-id-card-alt"></i> <strong>Profil :</strong> {{ $gestionnaire->profil }}</p>
        </div>
    </div>

    {{-- Message flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            🎉 {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tontines attribuées --}}
    <h4 class="text-info mt-5"><i class="fas fa-link"></i> Tontines attribuées</h4>

    @if($tontinesAttribuees->isEmpty())
        <div class="alert alert-info mt-2">Aucune tontine attribuée pour l’instant.</div>
    @else
        <ul class="list-group mb-4 mt-3">
            @foreach($tontinesAttribuees as $tontine)
                @php
                    $nbActuel = $tontine->participants()->count();
                    $max = $tontine->nbreParticipant;
                @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $tontine->libelle }}</strong><br>
                        <small>{{ ucfirst(strtolower($tontine->frequence)) }} — {{ $tontine->dateDebut }} → {{ $tontine->dateFin }}</small><br>

                        {{-- Badge statut --}}
                        @if($nbActuel >= $max || !$tontine->inscription_ouverte)
                            <span class="mt-2" style="color: red; font-weight: bold;">
                                <i class="fas fa-circle text-danger me-1"></i> Fermée
                            </span>
                        @else
                            <span class="mt-2" style="color: green; font-weight: bold;">
                                <i class="fas fa-circle text-success me-1"></i> Ouvert
                            </span>
                        @endif

                    </div>

                    {{-- Action retrait --}}
                    <form method="POST" action="{{ route('admin.gestionnaires.retirer', ['user' => $gestionnaire->id, 'tontine' => $tontine->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-unlink"></i> Retirer
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Tontines libres --}}
    <h4 class="text-warning"><i class="fas fa-circle-plus"></i> Tontines libres</h4>

    @if($tontinesLibres->isEmpty())
        <div class="alert alert-secondary mt-2">Aucune tontine libre disponible.</div>
    @else
        <ul class="list-group mt-3">
            @foreach($tontinesLibres as $tontine)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $tontine->libelle }}</strong><br>
                        <small>{{ ucfirst(strtolower($tontine->frequence)) }} – {{ $tontine->nbreParticipant }} participants</small>
                    </div>

                    <form action="{{ route('admin.gestionnaires.assigner', ['user' => $gestionnaire->id, 'tontine' => $tontine->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-link"></i> Assigner
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
    <div style="height: 100px">

    </div>
</div>
@endsection
