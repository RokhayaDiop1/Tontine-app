@extends('layouts.admin')

@section('contenu')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #78a7f9;
        box-shadow: 0 0 0 0.2rem rgba(120, 167, 249, 0.25);
    }

    .form-control, .form-select {
        border: 2px solid #240348;
    }

    .custom-card-header {
        background: linear-gradient(to right, #240348, #78a7f9);
        color: white;
    }

    .btn-success {
        background: linear-gradient(to right, #240348, #78a7f9);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(to right, #78a7f9, #240348);
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header custom-card-header text-center">
                    <h4><i class="fas fa-plus-circle me-2"></i>Créer une nouvelle tontine</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.tontines.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="libelle" class="form-label">Nom de la tontine</label>
                                <input type="text" name="libelle" class="form-control" placeholder="Ex: Tontine Diambar" required>
                            </div>

                            <div class="col-md-6">
                                <label for="frequence" class="form-label">Fréquence</label>
                                <select name="frequence" class="form-select" required>
                                    <option value="">-- Sélectionnez une fréquence --</option>
                                    <option value="JOURNALIERE">Journalière</option>
                                    <option value="HEBDOMADAIRE">Hebdomadaire</option>
                                    <option value="MENSUELLE">Mensuelle</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dateDebut" class="form-label">Date de début</label>
                                <input type="date" name="dateDebut" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="dateFin" class="form-label">Date de fin</label>
                                <input type="date" name="dateFin" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Décrivez la tontine..." required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="montant_de_base" class="form-label">Montant par personne (FCFA)</label>
                                <input type="number" name="montant_de_base" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="montant_total" class="form-label">Montant total (FCFA)</label>
                                <input type="number" name="montant_total" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nbreParticipant" class="form-label">Nombre de participants</label>
                                <input type="number" name="nbreParticipant" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="form-label">Gérant assigné</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Sélectionner un gérant --</option>
                                @foreach($gerants as $gerant)
                                    <option value="{{ $gerant->id }}">{{ $gerant->prenom }} {{ $gerant->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check-circle me-1"></i>Créer la tontine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div style="height: 50px;"></div>
        </div>
    </div>
</div>
@endsection
