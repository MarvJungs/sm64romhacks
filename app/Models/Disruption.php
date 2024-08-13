<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disruption extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'text',
        'active'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
