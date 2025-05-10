@extends('layouts.participant')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary mb-4 text-center">Historique de mes cotisations</h3>

    @if($cotisations->count())
        <div class="table-responsive">
            <table class="table table-bordered shadow-sm bg-white">
                <thead class="table-success text-center">
                    <tr>
                        <th>Tontine</th>
                        <th>Date d’échéance</th>
                        <th>Montant</th>
                        <th>Moyen de paiement</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    @foreach($cotisations as $cotisation)
                        <tr>
                            <td>{{ $cotisation->tontine->libelle }}</td>
                            <td>{{ \Carbon\Carbon::parse($cotisation->date_echeance)->format('d/m/Y') }}</td>
                            <td class="text-success fw-bold">{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $cotisation->moyen_paiement }}</td>
                            <td>
                                <span class="badge bg-success">Payée</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    @else
        <p class="text-center text-muted">Aucune cotisation effectuée pour le moment.</p>
    @endif
</div>
<div class="mb-3">
    <a href="{{ route('participant.dashboard') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
    </a>
</div>

@endsection
