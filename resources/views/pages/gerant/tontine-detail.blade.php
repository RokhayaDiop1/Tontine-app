@extends('layouts.gerant')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary">📦 Détails de la Tontine</h3>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="text-dark fw-bold">{{ $tontine->libelle }}</h4>

            <p><strong>Fréquence :</strong> {{ ucfirst($tontine->frequence) }}</p>
            <p><strong>Durée :</strong> {{ $tontine->dateDebut }} → {{ $tontine->dateFin }}</p>
            <p><strong>Montant par personne :</strong> {{ number_format($tontine->montant_de_base) }} FCFA</p>
            <p><strong>Participants :</strong> {{ $tontine->participants->count() }} / {{ $tontine->nbreParticipant }}</p>

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

            <div class="d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ajouterParticipantModal">
                    <i class="fas fa-user-plus"></i> Ajouter un participant
                </button>

                <a href="#" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-money-bill-wave"></i> Cotisations
                </a>

                <a href="#" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-random"></i> Tirage
                </a>
            </div>
        </div>
    </div>

    <h4 class="mt-5 text-primary">👥 Participants</h4>

    @if($tontine->participants->isEmpty())
        <div class="alert alert-info">Aucun participant pour cette tontine.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>État cotisation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tontine->participants as $participant)
                        <tr>
                            <td>{{ $participant->user->prenom }} {{ $participant->user->nom }}</td>
                            <td>{{ $participant->user->email }}</td>
                            <td>{{ $participant->user->telephone }}</td>
                            <td>
                                @if($participant->statut === 'payé')
                                    <span class="badge bg-success">Payé</span>
                                @else
                                    <span class="badge bg-danger">Non payé</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info">Détails</a>
                                <a href="#" class="btn btn-sm btn-outline-success">Marquer payé</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modal: Ajouter un Participant -->
<div class="modal fade" id="ajouterParticipantModal" tabindex="-1" aria-labelledby="ajouterParticipantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('participants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tontine_id" value="{{ $tontine->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un participant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">

                    @if(isset($users))
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Utilisateur existant</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Sélectionner un utilisateur --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="dateNaissance" class="form-label">Date de naissance</label>
                        <input type="date" name="dateNaissance" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cni" class="form-label">Numéro CNI</label>
                        <input type="text" name="cni" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="imageCni" class="form-label">Image CNI (facultative)</label>
                        <input type="file" name="imageCni" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
