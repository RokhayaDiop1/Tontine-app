@extends('layouts.admin') {{-- ou ton layout --}}

@section('contenu')

<div class="container">
    <h3 class="mb-4">Liste des gestionnaires</h3>

    <!-- Bouton -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#ajoutGestionnaireModal">
        <i class="fas fa-plus-circle"></i> Nouveau gestionnaire
    </button>

    <!-- Tableau -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nom et Prénom</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Date inscription</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gestionnaires as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ route('admin.gestionnaires.show', $user->id) }}">
                            {{ $user->nom }} {{ $user->prenom }}
                        </a>
                    </td>
                    <td>{{ $user->telephone }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-info">{{ $user->profil }}</span></td>
                    <td><span class="badge badge-success">ACTIF</span></td>
                    <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                    <td>
                        <!-- Bouton modifier -->
                        <a href="{{ route('admin.gestionnaires.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
            
                        <!-- Bouton supprimer -->
                        <form action="{{ route('admin.gestionnaires.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger delete-btn">Supprimer</button>
                        </form>
                        
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    // Lors du clic sur le bouton de suppression
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Confirmation avec SweetAlert2
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: 'Cela supprimera définitivement ce gestionnaire.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Soumettre le formulaire si confirmé
                    button.closest('form').submit();
                }
            });
        });
    });
</script>



<!-- Modal -->
<div class="modal fade" id="ajoutGestionnaireModal" tabindex="-1" role="dialog" aria-labelledby="ajoutGestionnaireModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('admin.gestionnaires.ajouter') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un nouveau gestionnaire</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </form>
  </div>
  <div style="height: 100px">

  </div>
</div>
@endsection
