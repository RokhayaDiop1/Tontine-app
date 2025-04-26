@extends('layouts.gerant')

@section('content')
    <h2>Bienvenue {{ Auth::user()->prenom }} 👋</h2>
    <p>Cette section sera bientôt disponible.</p>
@endsection
