<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hack extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'megapack',
        'verified',
        'rejected'
    ];

    protected $appends = ['total_downloads', 'release_date', 'starcount', 'authors'];

    protected function getTotalDownloadsAttribute()
    {
        return (int)$this->versions()->sum('downloadcount');
    }

    protected function getReleaseDateAttribute()
    {
        return $this->versions()->orderBy('releasedate', 'asc')->pluck('releasedate')->first();
    }

    protected function getStarcountAttribute()
    {
        return $this->versions()->max('starcount');
    }

    protected function getAuthorsAttribute()
    {
        $firstVersion = $this->versions()->orderBy('releasedate', 'asc')->first();
        if ($firstVersion) {
            // $authors = $firstVersion->authors->pluck('name')->toArray();
            return $firstVersion->authors->pluck('name');
        }
        return ['unknown'];
    }

    public function versions(): HasMany
    {
        return $this->HasMany(Version::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
