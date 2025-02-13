<?php

namespace App\Http\Controllers;

use App\Jobs\FillPokemonTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{

    public function fillTable(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('pokemon')->truncate();
        DB::table('pokemon_species')->truncate();
        DB::table('types')->truncate();
        DB::table('moves')->truncate();
        DB::table('move_pokemon')->truncate();
        DB::table('abilities')->truncate();
        DB::table('ability_pokemon')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $pokemonArray = json_decode(Http::get("https://pokeapi.co/api/v2/pokemon?limit=1000000&offset=0"), true);
        $pokemonArrayChunked = array_chunk($pokemonArray['results'], 5);
        foreach($pokemonArrayChunked as $pokemonArrayChunk) {
            dispatch(new FillPokemonTable($pokemonArrayChunk))->onQueue('fill-pokemon-table');
        }
    }
}
