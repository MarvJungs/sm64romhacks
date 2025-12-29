<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = ['filename'];
    public function romhack(): BelongsTo
    {
        return $this->belongsTo(Romhack::class);
    }
}
