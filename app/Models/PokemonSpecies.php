<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PokemonSpecies extends Model
{
    protected $fillable = [
        'name',
        'primary_pokemon_type',
    ];

    public function pokemon(): HasMany
    {
        return $this->hasMany(Pokemon::class);
    }
}
