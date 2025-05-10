<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\GerantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\TontineController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Page d'accueil
Route::get('/', [InscriptionController::class, 'home'])->name('home');

// Inscription
Route::get('register', [InscriptionController::class, 'index'])->name('inscription.index');
Route::post('validate-register', [InscriptionController::class, 'register'])->name('inscription.register');

// Authentification
Route::get('connexion', [AuthController::class, 'create'])->name('auth.create');
Route::post('connexion', [AuthController::class, 'auth'])->name('auth.store');

// Dashboards protégés par middleware
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-admin', fn() => view('pages.admin.dashboard'))->name('admin.dashboard');
    Route::get('/dashboard-gerant', fn() => view('pages.gerant.dashboard'))->name('gerant.dashboard');
    Route::get('/dashboard-participant', fn() => view('pages.participant.dashboard'))->name('participant.dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-admin', function () {
        return view('pages.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/gestionnaires', function () {
        return view('pages.admin.gestionnaires');
    })->name('admin.gestionnaires');

    Route::get('/admin/membres', function () {
        return view('pages.admin.membres');
    })->name('admin.membres');

    Route::get('/admin/creer-tontine', function () {
        return view('pages.admin.creer-tontine');
    })->name('admin.creer-tontine');

    Route::get('/admin/liste-tontines', function () {
        return view('pages.admin.liste-tontines');
    })->name('admin.liste-tontines');

    Route::get('/admin/statistiques', function () {
        return view('pages.admin.statistiques');
    })->middleware('auth')->name('admin.statistiques');
    
});



Route::get('/admin/gestionnaires', [AdminController::class, 'gestionnaires'])->name('admin.gestionnaires');
Route::post('/admin/gestionnaires/ajouter', [AdminController::class, 'ajouterGestionnaire'])->name('admin.gestionnaires.ajouter');


Route::get('/admin/gestionnaires/{id}', [AdminController::class, 'show'])->name('admin.gestionnaires.show');

Route::middleware('auth')->group(function () {
    Route::get('/admin/creer-tontine', [TontineController::class, 'create'])->name('admin.creer-tontine');
    Route::post('/admin/creer-tontine', [TontineController::class, 'store'])->name('admin.tontines.store');
    Route::get('/admin/liste-tontines', [TontineController::class, 'index'])->name('admin.liste-tontines');
});


Route::post('/admin/gestionnaires/{user}/assigner-tontine/{tontine}', [AdminController::class, 'assignerTontine'])->name('admin.gestionnaires.assigner');
Route::post('/admin/gestionnaires/{user}/retirer-tontine/{tontine}', [AdminController::class, 'retirerTontine'])->name('admin.gestionnaires.retirer');


// Route pour afficher le formulaire de modification
Route::get('/admin/gestionnaires/{id}/edit', [AdminController::class, 'edit'])->name('admin.gestionnaires.edit');

// Route pour mettre à jour les informations du gestionnaire
Route::put('/admin/gestionnaires/{id}', [AdminController::class, 'update'])->name('admin.gestionnaires.update');

// Route pour supprimer un gestionnaire
Route::delete('/admin/gestionnaires/{id}', [AdminController::class, 'destroy'])->name('admin.gestionnaires.destroy');

// Modifier une tontine
Route::get('/admin/tontines/{id}/edit', [TontineController::class, 'edit'])->name('admin.tontines.edit');

// Mettre à jour une tontine
Route::put('/admin/tontines/{id}', [TontineController::class, 'update'])->name('admin.tontines.update');

// Supprimer une tontine
Route::delete('/admin/tontines/{id}', [TontineController::class, 'destroy'])->name('admin.tontines.destroy');



Route::middleware('auth')->get('/dashboard-gerant', function () {
    return view('pages.gerant.dashboard');
})->name('gerant.dashboard');

Route::middleware(['auth'])->prefix('gerant')->name('gerant.')->group(function () {

    // Tableau de bord
    Route::get('/dashboard', fn() => view('pages.gerant.dashboard'))->name('dashboard');

    // ✅ Mes tontines (tontines du gérant connecté)
    Route::get('/tontines', [TontineController::class, 'tontinesDuGerant'])->name('tontines');

    // Participants
    Route::get('/participants', [App\Http\Controllers\ParticipantController::class, 'participantsDuGerant'])->name('participants');

    // Cotisations
    Route::get('/cotisations', [App\Http\Controllers\CotisationController::class, 'cotisationsDuGerant'])->name('cotisations');

    // Tirage
    Route::get('/tirage', [App\Http\Controllers\TirageController::class, 'tiragesDuGerant'])->name('tirage');
});
Route::post('/admin/tontines/{tontine}/toggle-inscription', [TontineController::class, 'toggleInscription'])
    ->name('admin.tontines.toggle-inscription');


Route::middleware('auth')->group(function () {
    Route::get('/gerant/tontine/{id}', [TontineController::class, 'show'])->name('tontine.show');
});

// ====================== PARTICIPANT ======================
Route::middleware(['auth'])->prefix('participant')->name('participant.')->group(function () {

    Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('dashboard');

    Route::get('/tontines', [ParticipantController::class, 'mesTontines'])->name('tontines');
    Route::get('/tontines/{id}', [ParticipantController::class, 'voirTontine'])->name('tontine.show');

    // Route::get('/cotisations', [ParticipantController::class, 'cotisations'])->name('cotisations');
    // Route::get('/profil', [ParticipantController::class, 'profil'])->name('profil');
    
});

Route::get('/participants/create/{tontine_id}', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/participants/store', [ParticipantController::class, 'store'])->name('participants.store');
// Afficher le formulaire de participation
Route::get('/tontines/{tontine}/participer', [ParticipantController::class, 'create'])->name('participants.create');

// Enregistrer la participation
Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
Route::delete('/tontine/{id}/quitter', [TontineController::class, 'quitter'])->name('tontine.quitter');
Route::get('/cotisation/{tontine}/create', [CotisationController::class, 'create'])->name('cotisation.create');
// Route::get('/participant/cotisations', [ParticipantController::class, 'cotisations'])->name('participant.cotisations');

// Route::get('/cotisation/payer/{tontine}', [CotisationController::class, 'create'])->name('cotisation.payer');
// Route::post('/cotisation/payer', [CotisationController::class, 'store'])->name('cotisation.store');
Route::get('/participant/tontine/{id}/cotisations', [CotisationController::class, 'voirCotisations'])->name('participant.tontine.cotisations');
Route::post('/cotisation/store', [CotisationController::class, 'store'])->name('cotisation.store');

Route::get('/participant/mes-cotisations', [App\Http\Controllers\CotisationController::class, 'historique'])->name('participant.cotisations');



Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');