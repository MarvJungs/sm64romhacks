<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Romhackevent extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_utc',
        'end_utc',
        'external',
        'external_url'
    ];

    protected function casts(): array
    {
        return [
            'description' => 'json',
            'external' => 'boolean'
        ];
    }

    /**
     * Get the route key for the model.
     * 
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
