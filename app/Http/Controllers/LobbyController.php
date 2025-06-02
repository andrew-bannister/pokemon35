<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
    public function getRandomPokemon(Request $request)
    {
        $pokemon = Pokemon::query()
            ->with(['primaryType', 'secondaryType'])
            ->inRandomOrder()
            ->get()
            ->unique('species_id')
            ->take(35);

        return response()->json([
            'pokemon' => $pokemon,
        ]);
    }
}
