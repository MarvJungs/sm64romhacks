<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Run extends Model
{
    protected $fillable = ['romhack', 'category', 'type'];

    public function romhackevent(): BelongsTo
    {
        return $this->belongsTo(Romhackevent::class);
    }

    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
