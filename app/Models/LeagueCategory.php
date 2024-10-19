<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LeagueCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'hack_id',
        'src_game_id',
        'src_category_id',
        'bonus_points'
    ];

    public function getRouteKeyName(): string
    {
        return 'src_category_id';
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function hack(): BelongsTo
    {
        return $this->belongsTo(Hack::class);
    }

    public function leaguePointsTables(): HasMany
    {
        return $this->hasMany(LeaguePointsTable::class);
    }

    public function leaguePointsPerSeconds(): HasMany
    {
        return $this->hasMany(LeaguePointsPerSecond::class);
    }

    protected function apiUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $baseAPIURL = 'https://www.speedrun.com/api/v1';
                list($category_id, $subcategory_id) = explode('+', $this->src_category_id);
                return "$baseAPIURL/leaderboards/$this->src_game_id/category/$category_id";
            }
        );
    }
}
