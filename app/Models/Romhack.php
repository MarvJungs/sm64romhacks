<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Stringable;

class Romhack extends Model implements Sitemapable
{
    use HasUuids;
    use HasSEO;

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the route key for the model.
     * 
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'videolink',
        'verified',
        'rejected',
        'megapack'
    ];

    protected function casts(): array
    {
        return [
            'description' => 'json',
            'megapack' => 'boolean',
            'verified' => 'boolean',
            'rejected' => 'boolean'
        ];
    }

    /**
     * Gets the versions associated with the Romhack
     * 
     * @return HasMany<Version, Romhack>
     */
    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Summary of romhacktags
     * 
     * @return BelongsToMany<Romhacktag, Romhack, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function romhacktags(): BelongsToMany
    {
        return $this->belongsToMany(Romhacktag::class);
    }

    /**
     * Summary of comments
     * 
     * @return HasMany<Comment, Romhack>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected static function booted()
    {
        static::creating(
            function (Romhack $romhack) {
                $romhack->slug = Str::slug($romhack->name);
            }
        );

        static::updating(
            function (Romhack $romhack) {
                $romhack->slug = Str::slug($romhack->name);
            }
        );
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->name,
            description: $this->getDescriptionForSEOTags(),
        );
    }

    public function getDescriptionForSEOTags(): Stringable | null
    {
        $descriptionObject = $this->description;
        if ($descriptionObject === null) {
            return null;
        }
        $blocks = Arr::get($descriptionObject, 'blocks');
        $data = Arr::flatten(Arr::pluck($blocks, 'data'));
        $description = Arr::join($data, '. ');
        return Str::of($description)->stripTags();
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('hack.show', $this))
            ->setLastModificationDate($this->updated_at);
    }
}
