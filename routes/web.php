<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

//ACCÈS PUBLIC
Route::get('/', function () {
    return view('welcome');
});

//LOGIQUE AUTHENTIFICATION
Auth::routes();

//ESPACE SÉCURISÉ (Utilisateurs connectés)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Ton travail)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestion des boissons (Ton travail)
    Route::resource('boissons', BoissonController::class);

    // Gestion du Profil (Le travail de ton camarade intégré ici)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');
    
});