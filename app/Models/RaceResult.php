<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaceResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'sr1Time',
        'sr2Time',
        'sr3Time',
        'sr4Time',
        'sr5Time',
        'sr6Time',
        'sr7Time',
        'sr8Time',
        'totalStars'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function totalTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sr1Time + $this->sr2Time + $this->sr3Time + $this->sr4Time + $this->sr5Time + $this->sr6Time + $this->sr7Time + $this->sr8Time
        );
    }
}
