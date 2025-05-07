@extends('layouts.admin')

@section('contenu')
<div class="container-fluid mt-4" style="max-width: 95%;">
    <h2 class="mb-4 text-primary">
        <i class="fas fa-list"></i> Liste des tontines
    </h2>

   

    @if($tontines->isEmpty())
        <div class="alert alert-info">Aucune tontine enregistrée pour le moment.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="thead-dark">
                    <tr style="background-color: #78a7f9; color: #ffffff;">
                        <th>Libellé</th>
                        <th>Fréquence</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Montant/pers</th>
                        <th>Total</th>
                        <th>Participants</th>
                        <th>Inscription</th>
                        <th>Gérant</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tontines as $tontine)
                        @php
                            $inscrits = $tontine->participants->count();
                            $complet = $inscrits >= $tontine->nbreParticipant;
                            $ouvert = $tontine->inscription_ouverte && !$complet;
                        @endphp

                        <tr>
                            <td class="text-primary fw-bold">{{ $tontine->libelle }}</td>
                            <td>{{ ucfirst(strtolower($tontine->frequence)) }}</td>
                            <td>{{ $tontine->dateDebut }}</td>
                            <td>{{ $tontine->dateFin }}</td>
                            <td>{{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</td>
                            <td>
                                {{ $inscrits }} / {{ $tontine->nbreParticipant }}
                            </td>

                            <td>
                                <form action="{{ route('admin.tontines.toggle-inscription', $tontine->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $tontine->inscription_ouverte ? 'btn-outline-success' : 'btn-outline-danger' }}">
                                        <i class="fas fa-circle {{ $tontine->inscription_ouverte ? 'text-success' : 'text-danger' }}"></i>
                                        {{ $tontine->inscription_ouverte ? 'Ouvert' : 'Fermé' }}
                                    </button>
                                </form>
                            </td>
                            

                            <td>
                                {{ $tontine->gerant->prenom ?? '—' }} {{ $tontine->gerant->nom ?? '' }}
                            </td>

                            <td>{{ Str::limit($tontine->description, 40) }}</td>

                            <td>
                                <a href="{{ route('admin.tontines.edit', $tontine->id) }}"
                                   class="btn btn-outline-primary btn-xs px-2 py-1" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Bouton Supprimer -->
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger px-2 py-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-delete-{{ $tontine->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <!-- Modal de confirmation -->
                                <div class="modal fade" id="modal-delete-{{ $tontine->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $tontine->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="modalLabel{{ $tontine->id }}">Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                        Voulez-vous vraiment <strong>supprimer</strong> la tontine <span class="text-danger">"{{ $tontine->libelle }}"</span> ?
                                        </div>
                                        <div class="modal-footer">
                                        <form method="POST" action="{{ route('admin.tontines.destroy', $tontine->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
  
                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

{{-- @push('scripts')
<script>
    // Confirmation avant suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Supprimer cette tontine ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush --}}