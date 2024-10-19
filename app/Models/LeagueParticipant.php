<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LeagueParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'src_name'
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function leaguePointsTable(): HasOne
    {
        return $this->hasOne(LeaguePointsTable::class);
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => strtolower($value)
        );
    }
}
