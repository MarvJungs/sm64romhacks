<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Newspost extends Model
{
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
}
