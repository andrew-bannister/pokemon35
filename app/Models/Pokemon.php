<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pokemon extends Model
{
    protected $fillable = [
        'name',
        'primary_type',
        'secondary_type',
        'category',
        'species_id',
        'base_hp',
        'base_attack',
        'base_defense',
        'base_special_attack',
        'base_special_defense',
        'base_speed',
        'image_url',
        'created_at',
        'updated_at',
    ];

    public function abilities(): HasMany
    {
        return $this->hasMany(Ability::class);
    }

    public function moves(): BelongsToMany
    {
        return $this->belongsToMany(Move::class);
    }

    public function primaryType(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'primary_type');
    }

    public function secondaryType(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'secondary_type');
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(PokemonSpecies::class);
    }
}
