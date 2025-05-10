@extends('layouts.participant')

@section('content')
<style>
    .form-wrapper {
        max-width: 600px;
        margin: 60px auto;
        background: #ffffff;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .form-wrapper h4 {
        color: #0b1c4c;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .btn-submit {
        background: linear-gradient(to right, #0b1c4c, #355dff);
        color: white;
        font-weight: bold;
        border: none;
    }

    .btn-submit:hover {
        background: linear-gradient(to right, #355dff, #0b1c4c);
    }
</style>

<div class="form-wrapper">
    <h4>Participer à la tontine : {{ $tontine->libelle }}</h4>

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

        <div class="mb-3">
            <label for="dateNaissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
            <input type="date" name="dateNaissance" class="form-control" value="{{ old('dateNaissance', $participant->dateNaissance ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="cni" class="form-label">Numéro de CNI <span class="text-danger">*</span></label>
            <input type="text" name="cni" class="form-control" value="{{ old('cni', $participant->cni ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
            <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $participant->adresse ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="imageCni" class="form-label">Photo de votre CNI <span class="text-danger">*</span></label>
            <input type="file" name="imageCni" class="form-control" accept="image/*" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-submit">Valider la participation</button>
        </div>
    </form>
</div>
@endsection
