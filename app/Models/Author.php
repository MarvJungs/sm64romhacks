<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_id',
        'name'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function versions(): BelongsToMany
    {
        return $this->belongsToMany(Version::class);
    }
}
