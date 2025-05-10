@extends('layouts.gerant')

@section('content')
<style>
    body {
        background-color: #0b1c4c !important;
    }

    .card-custom {
        background-color: #0b1c4c; /* plus clair que le fond */
        color: white;
        border: none;
        border-radius: 15px;
    }

    .list-group-item {
        background-color: #0b1c4c;
        color: white;
        border: 1px solid #0b1c4c;
    }

    .list-group-item strong {
        color: #ffc107; /* jaune clair */
    }

    .badge.bg-primary {
        background-color: #ffc107;
        color: #0b1c4c;
    }
</style>


<div class="container mt-5" >
    <div class="text-center mb-5">
        <h2 class="text-primary fw-bold">Bienvenue, {{ Auth::user()->prenom }} </h2>
        <p class="text-muted fs-5">Voici votre tableau de bord <strong>Gérant</strong> sur <span class="text-info">KAAY NAAT</span></p>
    </div>

    {{-- Infos du Gérant --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card card-custom shadow border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3"><i class="fas fa-user"></i></div>
                        <h5 class="mb-0">Vos informations</h5>
                    </div>
                    <ul class="list-unstyled">
                        <li><strong>Nom :</strong> {{ Auth::user()->nom }} {{ Auth::user()->prenom }}</li>
                        <li><strong>Email :</strong> {{ Auth::user()->email }}</li>
                        <li><strong>Téléphone :</strong> {{ Auth::user()->telephone }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Tontines attribuées --}}
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card card-custom shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3"><i class="fas fa-piggy-bank"></i></div>
                        <h5 class="mb-0">Vos Tontines attribuées</h5>
                    </div>

                    @php
                        $tontines = \App\Models\Tontine::where('user_id', Auth::id())->get();
                    @endphp

                    @if($tontines->isEmpty())
                        <p class="text-muted">Aucune tontine ne vous a encore été attribuée.</p>
                    @else
                        <ul class="list-group">
                            @foreach($tontines as $tontine)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $tontine->libelle }}</strong>
                                        <br>
                                        <small class="text-muted">{{ ucfirst(strtolower($tontine->frequence)) }} | {{ $tontine->nbreParticipant }} participants</small>
                                    </div>
                                    <span class="badge bg-primary">{{ \Carbon\Carbon::parse($tontine->dateDebut)->format('d/m/Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
