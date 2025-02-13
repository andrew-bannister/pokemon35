<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MoveClass extends Model
{
    protected $table = 'move_class';

    protected $fillable = [
        'name',
    ];

    public function move(): BelongsToMany
    {
        return $this->belongsToMany(Move::class);
    }
}
