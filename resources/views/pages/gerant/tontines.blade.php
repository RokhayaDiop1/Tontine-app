@extends('layouts.gerant')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">📦 Mes Tontines</h3>

    @if($tontines->isEmpty())
        <div class="alert alert-info">Aucune tontine ne vous a encore été attribuée.</div>
    @else
        <div class="row">
            @foreach($tontines as $tontine)
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-hand-holding-usd"></i> {{ $tontine->libelle }}
                            </h5>
                            <p><strong>📆 Fréquence :</strong> {{ ucfirst(strtolower($tontine->frequence)) }}</p>
                            <p><strong>🗓 Date :</strong> {{ $tontine->dateDebut }} → {{ $tontine->dateFin }}</p>
                            <p><strong>👥 Participants :</strong> 
                                {{ $tontine->participants()->count() ?? 0 }} / {{ $tontine->nbreParticipant }}
                            </p>
                            
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
                            <div class="text-end mt-3">
                                <a href="{{ route('tontine.show', $tontine->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
<div style="height: 100px"></div>
@endsection
</div>