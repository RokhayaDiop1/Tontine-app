@extends('layouts.participant')

@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Participer à la tontine : {{ $tontine->libelle }}</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('participants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="tontine_id" value="{{ $tontine->id }}">

        <div class="form-group mb-3">
            <label for="dateNaissance">Date de naissance <span class="text-danger">*</span></label>
            <input type="date" name="dateNaissance" class="form-control"value="{{ old('dateNaissance', $participant->dateNaissance ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="cni">Numéro de CNI <span class="text-danger">*</span></label>
            <input type="text" name="cni" class="form-control"value="{{ old('cni', $participant->cni ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="adresse">Adresse <span class="text-danger">*</span></label>
            <input type="text" name="adresse" class="form-control"value="{{ old('adresse', $participant->adresse ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="imageCni">Photo de votre CNI <span class="text-danger">*</span></label>
            <input type="file" name="imageCni" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Valider la participation</button>
    </form>
</div>
@endsection
