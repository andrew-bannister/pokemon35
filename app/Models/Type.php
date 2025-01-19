<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    protected $fillable = [
        'name',
    ];

    public function moves(): BelongsToMany
    {
        return $this->belongsToMany(Move::class);
    }

    public function pokemon(): BelongsToMany
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
