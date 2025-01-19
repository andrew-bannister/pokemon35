<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function fillTable()
    {
        $pokedexNumber = 1;

        while (true) {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$pokedexNumber}");
            dd($response);
        }
    }
}
