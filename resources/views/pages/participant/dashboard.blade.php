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


    .btn-transparent-danger {
        background-color: transparent !important;
        border: 2px solid #f3eeee; /* rouge */
        color: #dc3545 !important;
        transition: all 0.3s ease;
    }

    .btn-transparent-danger:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
    }

    .btn-transparent-success {
        background-color: transparent !important;
        border: 2px solid #f2f3f3; /* vert */
        color: #eeefee !important;
        transition: all 0.3s ease;
    }

    .btn-transparent-success:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
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
                                @php
                                    $aujourdhui = \Carbon\Carbon::now();
                                    $debut = \Carbon\Carbon::parse($tontine->dateDebut);
                                    $fin = \Carbon\Carbon::parse($tontine->dateFin);
                                    $estTerminee = $fin->lt($aujourdhui);
                                    $estCommencee = $debut->lte($aujourdhui);
                                    $nbParticipants = \App\Models\Participant::where('tontine_id', $tontine->id)->count();
                                @endphp

                                <span class="badge
                                    @if($estTerminee)
                                        bg-danger
                                    @elseif($estCommencee && $nbParticipants >= $tontine->nbreParticipant)
                                        bg-success
                                    @else
                                        bg-warning
                                    @endif">
                                    @if($estTerminee)
                                        Terminée
                                    @elseif($estCommencee && $nbParticipants >= $tontine->nbreParticipant)
                                        En cours
                                    @else
                                        En attente
                                    @endif
                                </span>

                                <ul class="list-unstyled text-left mt-3 mb-0 small">
                                    <li><strong>Fréquence :</strong> {{ $tontine->frequence }}</li>
                                    <li><strong>Début :</strong> {{ $tontine->dateDebut }}</li>
                                    <li><strong>Fin :</strong> {{ $tontine->dateFin }}</li>
                                    <li><strong>Base :</strong> {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</li>
                                    <li><strong>Total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</li>
                                    <li><strong>Participants :</strong> {{ $nbParticipants }} / {{ $tontine->nbreParticipant }}</li>
                                </ul>
                                
                                @if($estTerminee || $nbParticipants >= $tontine->nbreParticipant)
                                    <button class="btn btn-secondary btn-sm mt-3" disabled>Participation fermée</button>
                                @else
                                    <a href="{{ route('participants.create', $tontine->id) }}" class="btn btn-primary btn-sm mt-3">Participer</a>
                                @endif
                                
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

    {{-- MES TONTINES --}}
<div id="section-mes-tontines" class="mb-5 pt-5">
    <h3 class="text-primary mb-4 text-center">Mes Tontines</h3>

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

                            {{-- Boutons --}}
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <form id="quit-form-{{ $tontine->id }}" action="{{ route('tontine.quitter', $tontine->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                
                                <button type="button" class="btn btn-transparent-danger btn-sm" onclick="confirmQuit({{ $tontine->id }})">Quitter</button>
                                
                            
                                <a href="{{ route('participant.tontine.cotisations', $tontine->id) }}" class="btn btn-transparent-success btn-sm">
                                    Faire ma cotisation
                                </a>
                                
                            </div>
                            

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">Vous n’avez encore rejoint aucune tontine.</p>
    @endif
</div>



    {{-- LIEN VERS PAGE COTISATIONS --}}
<div id="section-cotisations" class="mb-5 text-center">
    <h3 class="text-success mb-4">Mes Cotisations</h3>
    <a href="{{ route('participant.cotisations') }}" class="btn btn-outline-success btn-lg">
        Voir mes cotisations
    </a>
</div>

    
    {{-- PROCHAINE COLLECTE
    <div id="section-collecte" class="mb-5">
        <h3 class="text-warning mb-3">Prochaine Collecte</h3>
        <p>Détails sur la prochaine collecte prévue...</p>
    </div> --}}

    {{-- GAINS --}}
    <div id="section-gains" class="mb-5">
        <h3 class="text-info mb-3">Mes Gains</h3>
        <p>Visualisez vos gains obtenus dans les tontines...</p>
    </div>

</div>

<script>
    function confirmQuit(tontineId) {
        Swal.fire({
            title: 'Confirmer le départ',
            text: "Souhaitez-vous vraiment quitter cette tontine ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, quitter',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('quit-form-' + tontineId).submit();
            }
        });
    }
</script>

@endsection
