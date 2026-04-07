<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// --- MODULE : GESTION DES CLIENTS ET ADMINS ---

// Utilisation de la syntaxe en "String" pour éviter l'erreur de classe
Route::get('/utilisateurs', 'App\Http\Controllers\UserController@index')->name('users.index');
Route::get('/utilisateurs/creer', 'App\Http\Controllers\UserController@create')->name('users.create');
Route::post('/utilisateurs', 'App\Http\Controllers\UserController@store')->name('users.store');
Route::get('/utilisateurs/{user}/modifier', 'App\Http\Controllers\UserController@edit')->name('users.edit');
Route::put('/utilisateurs/{user}', 'App\Http\Controllers\UserController@update')->name('users.update');
Route::delete('/utilisateurs/{user}', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');