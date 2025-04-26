@extends('layouts.gerant')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 text-center mb-4">
            <h2>Bienvenue, {{ Auth::user()->prenom }} 👋</h2>
            <p class="text-muted">Voici votre tableau de bord en tant que <strong>Gérant</strong> sur <strong>KAAY NAAT</strong>.</p>
        </div>
    </div>

    {{-- Infos gérant --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-id-card"></i> Vos informations</h5>
                    <p><strong>Nom :</strong> {{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
                    <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Téléphone :</strong> {{ Auth::user()->telephone }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tontines attribuées au gérant --}}
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-list"></i> Vos tontines attribuées</h5>

                    @php
                        $tontines = \App\Models\Tontine::where('user_id', Auth::id())->get();
                    @endphp

                    @if($tontines->isEmpty())
                        <p class="text-muted">Aucune tontine ne vous a encore été attribuée.</p>
                    @else
                        <ul class="list-group">
                            @foreach($tontines as $tontine)
                                <li class="list-group-item">
                                    <strong>{{ $tontine->libelle }}</strong> —
                                    {{ ucfirst(strtolower($tontine->frequence)) }} —
                                    {{ $tontine->nbreParticipant }} participants
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
