<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; // Importation propre

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

    // Gestion des boissons (Ton travail)
    Route::resource('boissons', BoissonController::class);

    // Gestion du Profil (Travail intégré hier)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // MODULE WALID : GESTION DES UTILISATEURS (Sécurisé ici)
    Route::resource('users', UserController::class); 
    // Utiliser resource est plus court et gère index, create, store, edit, update, destroy d'un coup !
    
});