<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class News extends Model implements Sitemapable
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'important'
    ];

    public function toSitemapTag(): array|string|Url
    {
        return Url::create(route('news.show', $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
