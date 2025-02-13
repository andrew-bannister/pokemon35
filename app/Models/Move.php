<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Move extends Model
{
    protected $fillable = [
        'name',
        'move_slug',
        'type',
        'class',
        'base_power',
    ];

    public function pokemon(): BelongsToMany
    {
        return $this->belongsToMany(Pokemon::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(Type::class);
    }
}
