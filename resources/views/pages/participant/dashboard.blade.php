@extends('layouts.participant')

@section('content')

{{-- CSS inline ici pour que les animations fonctionnent directement --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .delay-0 { animation-delay: 0s; }
    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }

    #section-tontines {
        background-color: #0b1c4c;
        padding: 30px;
        border-radius: 12px;
    }

    .tontine-card {
        background-color: #0b1c4c;
        color: white;
        animation: fadeInUp 0.8s ease both;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .tontine-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="container-fluid py-4">

    {{-- HERO --}}
    <div class="row align-items-center mb-5" style="min-height: 550px;">
        <div class="col-md-6">
            <h1 class="display-4 text-primary">KAAY NAAT</h1>
            <h2 class="font-weight-bold text-dark" style="font-size: 36px;">Ma liberté financière solidaire</h2>
            <p class="lead mt-4">
                Gérez vos cotisations, suivez vos tontines et visualisez vos bénéfices en toute simplicité.
                
            </p>
            {{-- Test Debug --}} 
            <p style="color: red; font-weight: bold;">TEST DEBUG</p>

            <a href="#section-tontines" class="btn btn-warning btn-lg mt-3 fw-bold">
                Je découvre les tontines
            </a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/tontine-illustration.jpg') }}" alt="Illustration" class="img-fluid" style="max-height: 400px;">
        </div>
    </div>

    {{-- TONTINES DISPONIBLES --}}
    <div id="section-tontines" class="py-5 mb-5">
        <div class="container">
            <h4 class="text-white mb-5 text-center">Tontines Disponibles</h4>

            @if($tontines->count())
                <div class="row g-4 justify-content-center">
                    @foreach($tontines as $tontine)
                        <div class="col-md-4 col-sm-6">
                            <div class="bg-white rounded p-3 text-center shadow-sm fade-in-up delay-{{ $loop->index % 4 }}" style="min-height: 280px;">
                                <div class="mb-3">
                                    <i class="fas fa-piggy-bank fa-lg text-primary"></i>
                                </div>
                                <h6 class="text-primary mb-2 font-weight-bold">{{ $tontine->libelle }}</h6>
                                <span class="badge {{ $tontine->dateFin < now() ? 'badge-danger' : 'badge-success' }}">
                                    {{ $tontine->dateFin < now() ? 'Terminée' : 'En cours' }}
                                </span>
                                <ul class="list-unstyled text-left mt-3 mb-0 small">
                                    <li><strong>Fréquence :</strong> {{ $tontine->frequence }}</li>
                                    <li><strong>Début :</strong> {{ $tontine->dateDebut }}</li>
                                    <li><strong>Fin :</strong> {{ $tontine->dateFin }}</li>
                                    <li><strong>Base :</strong> {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</li>
                                    <li><strong>Total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</li>
                                    <li><strong>Participants :</strong> {{ $tontine->nbreParticipant }}</li>
                                    <a href="{{ route('participants.create', $tontine->id) }}" class="btn btn-primary btn-sm mt-3">Participer</a>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-light text-center">Aucune tontine trouvée.</p>
            @endif
        </div>
    </div>

    {{-- ACCÈS RAPIDE --}}
    <div class="row text-center mb-5">
        @php
            $sections = [
                ['id' => 'section-mes-tontines', 'icon' => 'fa-piggy-bank', 'title' => 'Tontines', 'text' => 'Mes Tontines', 'color' => 'primary'],
                ['id' => 'section-cotisations', 'icon' => 'fa-wallet', 'title' => 'Cotisations', 'text' => 'Statut des paiements', 'color' => 'success'],
                ['id' => 'section-collecte', 'icon' => 'fa-calendar-alt', 'title' => 'Prochaine collecte', 'text' => 'Date à venir', 'color' => 'warning'],
                ['id' => 'section-gains', 'icon' => 'fa-gift', 'title' => 'Vos gains', 'text' => 'Bénéfices cumulés', 'color' => 'info'],
            ];
        @endphp

        @foreach($sections as $index => $section)
            <div class="col-md-3">
                <a href="#{{ $section['id'] }}" class="text-decoration-none text-dark">
                    <div class="card shadow fade-in-up delay-{{ $index }}">
                        <div class="card-body">
                            <i class="fas {{ $section['icon'] }} fa-2x text-{{ $section['color'] }} mb-3"></i>
                            <h5>{{ $section['title'] }}</h5>
                            <p class="text-muted">{{ $section['text'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- {{-- MES TONTINES --}}
<div id="section-mes-tontines" class="mb-5 pt-5">
    <h3 class="text-center text-white mb-5">Mes Tontines</h3>

    @if($mesTontines->count())
        <div class="row justify-content-center g-4">
            @foreach($mesTontines as $tontine)
                <div class="col-md-4">
                    <div class="card text-white h-100 shadow-lg animate__animated animate__fadeInUp" style="background-color: #0b1c4c; border-radius: 15px;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-warning"></i>
                            </div>
                            <h5 class="mb-3">{{ $tontine->libelle }}</h5>
                            <ul class="list-unstyled small">
                                <li><strong>Fréquence :</strong> {{ $tontine->frequence }}</li>
                                <li><strong>Début :</strong> {{ $tontine->dateDebut }}</li>
                                <li><strong>Fin :</strong> {{ $tontine->dateFin }}</li>
                            </ul>
                            <a href="#" class="btn btn-outline-light mt-3">Détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">Vous n’avez encore rejoint aucune tontine.</p>
    @endif
</div>


    {{-- MES COTISATIONS --}}
    <div id="section-cotisations" class="mb-5">
        <h3 class="text-success mb-3">Mes Cotisations</h3>
        <p>Historique ou statut de vos cotisations...</p>
    </div>

    {{-- PROCHAINE COLLECTE --}}
    <div id="section-collecte" class="mb-5">
        <h3 class="text-warning mb-3">Prochaine Collecte</h3>
        <p>Détails sur la prochaine collecte prévue...</p>
    </div>

    {{-- GAINS --}}
    <div id="section-gains" class="mb-5">
        <h3 class="text-info mb-3">Mes Gains</h3>
        <p>Visualisez vos gains obtenus dans les tontines...</p>
        <p>Visualisez vos gains obtenus dans les tontines...</p>
    </div>

</div>
@endsection
