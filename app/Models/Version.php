<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Version extends Model
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

    protected $fillable = [
        'name',
        'starcount',
        'releasedate',
        'filename',
        'recommened',
        'demo'
    ];
    
    /**
     * Summary of romhack
     * 
     * @return BelongsTo<Romhack, Version>
     */
    public function romhack(): BelongsTo
    {
        return $this->belongsTo(Romhack::class);
    }

    /**
     * Summary of authors
     * 
     * @return HasMany<Author, Version>
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
