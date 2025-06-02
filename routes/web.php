<?php

use App\Http\Controllers\LobbyController;
use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return Inertia::render('Home');
});


Route::get('/fill-pokemon-table', [PokemonController::class, 'fillTable'])->name('fill-pokemon-table');

Route::get('/get-random-pokemon', [LobbyController::class, 'getRandomPokemon'])->name('get-random-pokemon');
