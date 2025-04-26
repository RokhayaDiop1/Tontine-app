@extends('app')

@section('contenu')
    <div class="d-flex justify-content-center align-items-center" style="height: 90vh; background: linear-gradient(to right,  #240348, #78a7f9);">
        <div class="text-center text-white animate__animated animate__fadeInDown">
            <!-- Image ou logo -->
            <img src="{{ asset('images/khalis.png') }}" alt="Logo"
            class="rounded-circle shadow"
            style="width: 150px; height: 150px; border: 4px solid white;">

            <!-- Titre principal -->
            <h1 class="display-4 fw-bold">Bienvenue sur <span class="text-warning">KAAY NAAT</span></h1>

            <!-- Slogan -->
            <h5 class="mb-4">Gérez votre collecte en toute simplicité</h5>

            <!-- Bouton animé -->
            <a href="connexion" class="btn btn-warning btn-lg animate__animated animate__pulse animate__infinite">
                Commencer maintenant
            </a>
            
        </div>
    </div>
@endsection
