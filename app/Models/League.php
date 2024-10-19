<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'league_points_system_id'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function leaguePointsSystem(): BelongsTo
    {
        return $this->belongsTo(LeaguePointsSystem::class);
    }

    public function leagueCategories(): HasMany
    {
        return $this->hasMany(LeagueCategory::class);
    }

    public function leagueParticipants(): HasMany
    {
        return $this->hasMany(LeagueParticipant::class);
    }
}
