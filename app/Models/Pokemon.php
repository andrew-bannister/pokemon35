<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pokemon extends Model
{
    protected $fillable = [
        'name',
        'primary_type',
        'secondary_type',
        'category',
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

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class);
    }

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }
}
