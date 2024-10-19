<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaguePointsTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_category_id',
        'league_participant_id',
        'personal_best',
        'points'
    ];

    public function leagueParticipant(): BelongsTo
    {
        return $this->belongsTo(LeagueParticipant::class);
    }

    public function leagueCategory(): BelongsTo
    {
        return $this->belongsTo(LeagueCategory::class);
    }
}
