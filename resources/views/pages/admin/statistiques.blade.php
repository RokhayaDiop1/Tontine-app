@extends('layouts.admin')

@section('contenu')
<div class="row">

    <!-- Utilisateurs -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Utilisateurs</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Tontines -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tontines</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Tontine::count() }}</div>
            </div>
        </div>
    </div>

    <!-- Participants -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Participants</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ \App\Models\User::where('profil', 'PARTICIPANT')->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Gérants -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Gérants</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ \App\Models\User::where('profil', 'GERANT')->count() }}
                </div>
            </div>
        </div>
    </div>

    <div style="height: 100px">

    </div>

</div>
@endsection
