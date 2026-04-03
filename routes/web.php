<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Afficher le formulaire de modification
Route::get('/profil', [ProfileController::class, 'edit']);

// Enregistrer les modifications
Route::post('/profil', [ProfileController::class, 'update']);