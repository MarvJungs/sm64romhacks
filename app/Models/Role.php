<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public const ADMIN = 705528016914087976;
    public const MODERATOR = 705528172581486704;
    public const SITE_HELPER = 705530192839311381;
    public const EVENT_MANAGER = 737674135747952660;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
