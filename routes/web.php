<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// 1. ACCÈS PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// 2. LOGIQUE AUTHENTIFICATION
Auth::routes();

// 3. ESPACE SÉCURISÉ (Utilisateurs connectés uniquement)
Route::middleware(['auth'])->group(function () {

    // Dashboard - Page d'accueil après connexion
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestion des boissons (Inventaire de la cave)
    Route::resource('boissons', BoissonController::class);

    // Gestion du Profil (Tes modifications Abdoul)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Module Walid : Gestion des Utilisateurs
    Route::resource('users', UserController::class);

});