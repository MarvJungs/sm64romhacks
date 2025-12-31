<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Stringable;

class Newspost extends Model implements Sitemapable
{
    use HasSEO;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'text'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Gets the author of the newspost
     * 
     * @return BelongsTo<User, Newspost>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'text' => 'json'
        ];
    }

    protected static function booted()
    {
        static::creating(
            function (Newspost $newspost) {
                if (empty($newspost->slug)) {
                    $baseSlug = Str::slug($newspost->title);
                    $slug = $baseSlug;
                    $counter = 1;

                    while (static::where('slug', $slug)->exists()) {
                        $counter++;
                        $slug = "$baseSlug-$counter";
                    }

                    $newspost->slug = $slug;
                }
            }
        );
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->name,
        );
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('newspost.show', $this))
            ->setLastModificationDate($this->updated_at);
    }
}
