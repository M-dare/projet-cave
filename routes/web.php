<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;

//ACCÈS PUBLIC
// Tout le monde peut voir la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

//LOGIQUE AUTHENTIFICATION
// Cette ligne crée : Inscription, Connexion, Déconnexion, et Récupération de mot de passe.
Auth::routes();

//ESPACE SÉCURISÉ 
// Le middleware 'auth' vérifie si l'utilisateur est connecté avant de le laisser passer.
Route::middleware(['auth'])->group(function () {
    
    // Page d'accueil après connexion (Dashboard)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestion des boissons (interdit aux personnes non connectées)
    Route::resource('boissons', BoissonController::class);
    
});