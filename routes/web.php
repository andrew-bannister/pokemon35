<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fill-pokemon-table', [PokemonController::class, 'fillTable'])->name('fill-pokemon-table');
