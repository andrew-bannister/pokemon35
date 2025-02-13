<?php

namespace App\Jobs;

use App\Models\Move;
use App\Models\MoveClass;
use App\Models\Pokemon;
use App\Models\PokemonSpecies;
use App\Models\Type;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FillPokemonTable implements ShouldQueue
{
    use Queueable;

    protected array $pokemon;

    /**
     * Create a new job instance.
     */
    public function __construct(array $pokemon)
    {
        $this->pokemon = $pokemon;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->pokemon as $mon) {
            $response = json_decode(Http::get($mon['url']), true);
            if (is_null($response)) {
                break;
            }
            $speciesLink = $response['species']['url'];
            $speciesResponse = json_decode(Http::get($speciesLink), true);

            $name = $response['name'];

            try {
                $types = $response['types'];
                $primaryType = $types[0]['type']['name'];
                $primaryTypeModel = Type::firstOrCreate(['name' => $primaryType]);
                $secondaryType = isset($types[1]) ? $types[1]['type']['name'] : null;
                unset($secondaryTypeModel);
                if (!is_null($secondaryType)) {
                    $secondaryTypeModel = Type::firstOrCreate(['name' => $secondaryType]);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error($types);
            }

            $category = array_filter($speciesResponse['genera'], function ($genus) {
                return $genus['language']['name'] == 'en';
            });
            $category = array_values($category)[0]['genus'];

            $species = PokemonSpecies::firstOrCreate(
                ['name' => $name],
                ['primary_pokemon_id' => null],
            );

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

            $pokemon = Pokemon::create([
                'name' => $name,
                'primary_type' => $primaryTypeModel->id,
                'secondary_type' => isset($secondaryTypeModel) ? $secondaryTypeModel->id : null,
                'category' => $category,
                'species_id' => $species->id,
                'base_hp' => $base_hp,
                'base_attack' => $base_attack,
                'base_defense' => $base_defense,
                'base_special_attack' => $base_special_attack,
                'base_special_defense' => $base_special_defense,
                'base_speed' => $base_speed,
                'image_url' => $imageUrl,
            ]);

            $species->primary_pokemon_id = $pokemon->id;
            $species->save();

            $moves = $response['moves'];

            foreach($moves as $move) {
                $storedMove = $this->checkMoveExistsOrCreate($move);
                DB::table('move_pokemon')->insert([
                    'move_id' => $storedMove->id,
                    'pokemon_id' => $pokemon->id,
                ]);
            }
        }
    }

    private function checkMoveExistsOrCreate($move)
    {
        $moveSlug = $move['move']['name'];
        $moveSet = Move::where('move_slug', $moveSlug)->first();
        if (! isset($moveSet)) {
            $response = json_decode(Http::get($move['move']['url']), true);
            $name = array_find($response['names'], function ($element) {
                return $element['language']['name'] == 'en';
            })['name'];

            $type = Type::firstOrCreate([
                'name' => $response['type']['name'],
            ])['id'];

            $class = MoveClass::where('name', $response['damage_class']['name'])->first()['id'];

            $basePower = $response['power'] ?? null;

            $moveSet = Move::create([
                'name' => $name,
                'move_slug' => $moveSlug,
                'type' => $type,
                'class' => $class,
                'base_power' => $basePower,
            ]);
        }
        return $moveSet;
    }
}
