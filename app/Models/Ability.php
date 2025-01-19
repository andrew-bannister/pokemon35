<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ability extends Model
{
    public function pokemon(): BelongsToMany
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
