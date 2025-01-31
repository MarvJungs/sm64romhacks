<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaceParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'sr1PB',
        'sr2PB',
        'sr3PB',
        'sr4PB',
        'sr5PB',
        'sr6PB',
        'sr7PB',
        'sr8PB',
        'accept_rules'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function totalPB(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sr1PB + $this->sr2PB + $this->sr3PB + $this->sr4PB + $this->sr5PB + $this->sr6PB + $this->sr7PB + $this->sr8PB
        );
    }
}
