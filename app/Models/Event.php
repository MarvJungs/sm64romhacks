<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([EventObserver::class])]
class Event extends Model implements Sitemapable
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'guild_schedule_id',
        'start_utc',
        'end_utc',
        'description',
        'event_type_id'
    ];

    public function toSitemapTag(): array|string|Url
    {
        return Url::create(route('events.show', $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.1);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function disruptions(): HasMany
    {
        return $this->hasMany(Disruption::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function league(): HasOne
    {
        return $this->hasOne(League::class);
    }
}
