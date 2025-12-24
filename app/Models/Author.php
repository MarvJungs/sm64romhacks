<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{

    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * Summary of versions
     * 
     * @return BelongsToMany<Version, Author, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function versions(): BelongsToMany
    {
        return $this->belongsToMany(Version::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
