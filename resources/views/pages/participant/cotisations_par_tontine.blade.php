@extends('layouts.participant')

@section('content')

<div class="container mt-5">
    <div class="mb-3">
    <a href="{{ route('participant.dashboard') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
    </a>
</div>

    
    <h3 class="text-primary text-center mb-4">
        Cotisations – {{ $tontine->libelle }}
    </h3>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm bg-white">
            <thead class="table-primary text-center">
                <tr>
                    <th>Date d’échéance</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                @foreach($echeances as $echeance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($echeance['date'])->format('d/m/Y') }}</td>
                        <td class="text-success fw-bold">{{ number_format($echeance['montant'], 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="badge 
                                @if($echeance['statut'] === 'Déjà payée') bg-success
                                @elseif($echeance['statut'] === 'À payer aujourd’hui') bg-warning text-dark
                                @elseif($echeance['statut'] === 'Retard') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $echeance['statut'] }}
                            </span>
                        </td>
                        <td>
                            @if(in_array($echeance['statut'], ['À payer aujourd’hui', 'Retard']))
                                <form action="{{ route('cotisation.store') }}" method="POST" class="d-flex gap-2 justify-content-center align-items-center">
                                    @csrf
                                    <input type="hidden" name="tontine_id" value="{{ $tontine->id }}">
                                    <input type="hidden" name="date_echeance" value="{{ $echeance['date'] }}">
                                    <input type="hidden" name="montant" value="{{ $echeance['montant'] }}">

                                    <select name="moyen_paiement" class="form-select form-select-sm w-auto" required>
                                        <option value="">Choisir</option>
                                        <option value="OM">Orange Money</option>
                                        <option value="WAVE">Wave</option>
                                    </select>

                                    <button type="submit" class="btn btn-success btn-sm">Payer</button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    
    
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Paiement réussi',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754'
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>
@endsection
