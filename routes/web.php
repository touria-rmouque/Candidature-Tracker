<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// page d'accueil
Route::get('/', fn () => redirect()->route('dashboard'));

// Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Candidature 
Route::middleware('auth')->group(function () {

    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('/candidatures/create', [CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::get('/candidatures/archives', [CandidatureController::class, 'archives'])->name('candidatures.archives');
    Route::patch('/candidatures/{id}/restore', [CandidatureController::class, 'restore'])->name('candidatures.restore');
    Route::delete('/candidatures/{id}/force-delete', [CandidatureController::class, 'forceDelete'])->name('candidatures.force-delete');
    
    Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show'])
        ->name('candidatures.show')
        ->withTrashed();
        
    Route::get('/candidatures/{candidature}/edit', [CandidatureController::class, 'edit'])
        ->name('candidatures.edit')
        ->withTrashed();
        
    Route::put('/candidatures/{candidature}', [CandidatureController::class, 'update'])
        ->name('candidatures.update')
        ->withTrashed();
        
    Route::delete('/candidatures/{candidature}', [CandidatureController::class, 'destroy'])
        ->name('candidatures.destroy')
        ->withTrashed();
        
    Route::get('/candidatures/{candidature}/fichier', [CandidatureController::class, 'downloadFichier'])
        ->name('candidatures.fichier')
        ->withTrashed();

    // Entretiens
    Route::get('/candidatures/{candidature}/entretiens/create', [EntretienController::class, 'create'])->name('entretiens.create');
    Route::post('/candidatures/{candidature}/entretiens', [EntretienController::class, 'store'])->name('entretiens.store');
    Route::get('/candidatures/{candidature}/entretiens/{entretien}/edit', [EntretienController::class, 'edit'])->name('entretiens.edit');
    Route::put('/candidatures/{candidature}/entretiens/{entretien}', [EntretienController::class, 'update'])->name('entretiens.update');
    Route::delete('/candidatures/{candidature}/entretiens/{entretien}', [EntretienController::class, 'destroy'])->name('entretiens.destroy');
});

require __DIR__.'/auth.php';