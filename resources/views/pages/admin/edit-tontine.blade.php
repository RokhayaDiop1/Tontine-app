@extends('layouts.admin')

@section('contenu')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">
        <i class="fas fa-edit"></i> Modifier la tontine : <strong>{{ $tontine->libelle }}</strong>
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.tontines.update', $tontine->id) }}" method="POST" class="card shadow p-4 border-left-primary">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="libelle" class="form-label">Libellé</label>
                <input type="text" name="libelle" class="form-control" value="{{ old('libelle', $tontine->libelle) }}" required>
            </div>

            <div class="col-md-6">
                <label for="frequence" class="form-label">Fréquence</label>
                <select name="frequence" class="form-select" required>
                    <option value="JOURNALIERE" @selected($tontine->frequence == 'JOURNALIERE')>JOURNALIERE</option>
                    <option value="HEBDOMADAIRE" @selected($tontine->frequence == 'HEBDOMADAIRE')>Hebdomadaire</option>
                    <option value="MENSUELLE" @selected($tontine->frequence == 'MENSUELLE')>Mensuelle</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dateDebut" class="form-label">Date de début</label>
                <input type="date" name="dateDebut" class="form-control" value="{{ old('dateDebut', $tontine->dateDebut) }}" required>
            </div>

            <div class="col-md-6">
                <label for="dateFin" class="form-label">Date de fin</label>
                <input type="date" name="dateFin" class="form-control" value="{{ old('dateFin', $tontine->dateFin) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $tontine->description) }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="montant_de_base" class="form-label">Montant par personne</label>
                <input type="number" name="montant_de_base" class="form-control" value="{{ old('montant_de_base', $tontine->montant_de_base) }}" required>
            </div>

            <div class="col-md-4">
                <label for="montant_total" class="form-label">Montant total</label>
                <input type="number" name="montant_total" class="form-control" value="{{ old('montant_total', $tontine->montant_total) }}" required>
            </div>

            <div class="col-md-4">
                <label for="nbreParticipant" class="form-label">Nombre de participants</label>
                <input type="number" name="nbreParticipant" class="form-control" value="{{ old('nbreParticipant', $tontine->nbreParticipant) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Gérant assigné</label>
            <select name="user_id" class="form-select">
                <option value="">Aucun</option>
                @foreach($gerants as $gerant)
                    <option value="{{ $gerant->id }}" @selected($tontine->user_id == $gerant->id)>
                        {{ $gerant->prenom }} {{ $gerant->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-end">
            <a href="{{ route('admin.liste-tontines') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
