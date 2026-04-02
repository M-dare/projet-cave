<?php

use Illuminate\Support\Facades\Route;
// On importe le contrôleur que vous venez de créer
use App\Http\Controllers\BoissonController;
//  Web Routes
// Page d'accueil du site
Route::get('/', function () {
    return view('welcome');
});

// Route "Resource" : Elle crée 7 routes en 1 seule ligne pour vos boissons !
// (index, create, store, show, edit, update, destroy)
Route::resource('boissons', BoissonController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
