<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Romhacktag extends Model
{

    protected $fillable = ['name'];

    public function romhacks(): BelongsToMany
    {
        return $this->belongsToMany(Romhack::class);
    }
}
