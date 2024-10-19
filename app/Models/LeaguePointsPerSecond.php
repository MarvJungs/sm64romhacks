<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LeaguePointsPerSecond extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_category_id',
        'cutoff',
        'points_per_second',
        'tier'
    ];

    public function leagueCategory(): BelongsTo
    {
        return $this->belongsTo(LeagueCategory::class);
    }

    protected function cutoffT(): Attribute
    {
        return Attribute::make(
            get: function () {
                $cutoff = $this->cutoff;
                $timeArray = Carbon::createFromFormat('H:i:s', $cutoff)->toArray();
                return $timeArray['hour'] * 3600 + $timeArray['minute'] * 60 + $timeArray['second'];
            }
        );
    }
}
