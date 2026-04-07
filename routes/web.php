<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Vérifie bien que ces fichiers existent dans app/Http/Controllers
use App\Http\Controllers\BoissonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

// 1. ACCÈS PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// 2. AUTHENTIFICATION (Géré par UI ou Breeze)
Auth::routes();

// 3. ESPACE SÉCURISÉ (Utilisateurs connectés)
Route::middleware(['auth'])->group(function () {

    // Dashboard (L'adresse sera http://127.0.0.1:8000/home)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Gestion des boissons (Cave)
    Route::resource('boissons', BoissonController::class);

    // Profil (Tes modifications d'aujourd'hui)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');

});