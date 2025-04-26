@extends('layouts.admin')

@section('contenu')

<div class="container">
    <h3 class="mb-4">Modifier l'utilisateur</h3>

    <form action="{{ route('admin.gestionnaires.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
        </div>

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Sauvegarder les modifications</button>
    </form>
</div>

@endsection
