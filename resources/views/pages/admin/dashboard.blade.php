@extends('layouts.admin')

@section('contenu')
    <div class="text-center mt-5">
        <h1 class="h3 text-primary">Bienvenue Super Admin 👑</h1>
        <p>Gérez votre plateforme depuis ce tableau de bord.</p>
    </div>

    <div class="container">
        <div class="row justify-content-center">
    
            <!-- Carte Gestionnaires -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.gestionnaires') }}" class="text-decoration-none">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body text-center">
                            <i class="fas fa-user-tie fa-2x text-primary mb-2"></i>
                            <h5 class="text-primary">Gestionnaires</h5>
                            <a href="{{ route('admin.gestionnaires') }}" class="btn btn-primary mt-2">
                                Voir et gérer les gestionnaires
                            </a>
                        </div>
                    </div>
                </a>
            </div>
    
            <!-- Carte Membres -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.membres') }}" class="text-decoration-none">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x text-warning mb-2"></i>
                            <h5 class="text-warning">Membres</h5>
                            <a href="{{ route('admin.membres') }}" class="btn btn-warning mt-2 text-white">
                                Voir et gérer les membres
                            </a>
                        </div>
                    </div>
                </a>
            </div>
    
            <!-- Carte Créer une tontine -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.creer-tontine') }}" class="text-decoration-none">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-2x text-success mb-2"></i>
                            <h5 class="text-success">Créer une tontine</h5>
                            <a href="{{ route('admin.creer-tontine') }}" class="btn btn-success mt-2">
                                Ajouter une nouvelle tontine
                            </a>
                        </div>
                    </div>
                </a>
            </div>
    
            <!-- Carte Liste des tontines -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.liste-tontines') }}" class="text-decoration-none">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-2x text-secondary mb-2"></i>
                            <h5 class="text-secondary">Liste des tontines</h5>
                            <a href="{{ route('admin.liste-tontines') }}" class="btn btn-secondary mt-2">
                                Voir les tontines existantes
                            </a>
                        </div>
                    </div>
                </a>
            </div>
    
            <!-- Carte Statistiques -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.statistiques') }}" class="text-decoration-none">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                            <h5 class="text-info">Statistiques</h5>
                            <a href="{{ route('admin.statistiques') }}" class="btn btn-info mt-2 text-white">
                                Voir les statistiques
                            </a>
                        </div>
                    </div>
                </a>
            </div>
    
        </div>
    </div>

@endsection
