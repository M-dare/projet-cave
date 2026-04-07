<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController; // Importation du nouveau contrôleur

// --- ACCÈS PUBLIC ---
Route::get('/', function () {
    return view('welcome');
});

// --- LOGIQUE AUTHENTIFICATION ---
Auth::routes();

// --- ESPACE SÉCURISÉ (Utilisateurs connectés uniquement) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestion des boissons
    Route::resource('boissons', BoissonController::class);

    // Gestion du Profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // MODULE WALID : GESTION DES UTILISATEURS
    Route::resource('users', UserController::class); 
    
    // MODULE VENTES (Ajouté pour le groupe)
    Route::resource('ventes', VenteController::class);
    
});