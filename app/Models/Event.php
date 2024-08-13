<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'horaro_id',
        'start_utc',
        'end_utc',
        'description',
        'marathon'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function disruptions(): HasMany
    {
        return $this->hasMany(Disruption::class);
    }
}
