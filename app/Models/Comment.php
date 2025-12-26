<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'romhack_id',
        'user_id',
        'text'
    ];
    
    /**
     * Summary of romhack
     * 
     * @return BelongsTo<Romhack, Comment>
     */
    public function romhack(): BelongsTo
    {
        return $this->belongsTo(Romhack::class);
    }

    /**
     * Summary of user
     * 
     * @return BelongsTo<User, Comment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of rating
     * 
     * @return HasMany<Commentrating, Comment>
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Commentrating::class);
    }
}
