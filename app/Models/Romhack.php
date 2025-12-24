<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Romhack extends Model
{
    use HasUuids;
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
}
