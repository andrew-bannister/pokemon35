<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function __construct(Pokemon $table)
    {
        $this->table = $table;
    }

    public function fillTable(): void
    {
        $this->table->truncate();

        $pokedexNumber = 1;

        while (true) {
            $response = json_decode(Http::get("https://pokeapi.co/api/v2/pokemon/{$pokedexNumber}"), true);
            if (is_null($response)) {
                break;
            }

            $speciesLink = $response['species']['url'];
            $speciesResponse = json_decode(Http::get($speciesLink), true);

            $name = $response['name'];

            $types = $response['types'];
            $primaryType = $types[0]['type']['name'];
            $primaryTypeModel = Type::firstOrCreate(['name' => $primaryType]);
            $secondaryType = isset($types[1]) ? $types[1]['type']['name'] : null;
            unset($secondaryTypeModel);
            if (!is_null($secondaryType)) {
                $secondaryTypeModel = Type::firstOrCreate(['name' => $secondaryType]);
            }

            $category = array_filter($speciesResponse['genera'], function ($genus) {
                return $genus['language']['name'] == 'en';
            });
            $category = array_values($category)[0]['genus'];

            $stats = $response['stats'];
            $statsNames = [
                'hp',
                'attack',
                'defense',
                'special-attack',
                'special-defense',
                'speed',
            ];
            foreach ($statsNames as $statName) {
                $baseStat = 'base_' . str_replace('-', '_', $statName);
                ${$baseStat} = array_filter($stats, function ($stat) use ($statName) {
                    return $stat['stat']['name'] == $statName;
                });
                ${$baseStat} = array_values(${$baseStat})[0]['base_stat'];
            }

            $imageUrl = $response['sprites']['other']['home']['front_default'];

            $this->table->create([
                'name' => $name,
                'primary_type' => $primaryTypeModel->id,
                'secondary_type' => isset($secondaryTypeModel) ? $secondaryTypeModel->id : null,
                'category' => $category,
                'base_hp' => $base_hp,
                'base_attack' => $base_attack,
                'base_defense' => $base_defense,
                'base_special_attack' => $base_special_attack,
                'base_special_defense' => $base_special_defense,
                'base_speed' => $base_speed,
                'image_url' => $imageUrl,
            ]);

            $pokedexNumber++;
        }
    }
}
