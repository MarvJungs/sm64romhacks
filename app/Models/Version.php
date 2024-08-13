<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Version extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'hack_id',
        'name',
        'starcount',
        'releasedate',
        'downloadcount',
        'filename',
        'recommend'
    ];

    public function hack(): BelongsTo
    {
        return $this->belongsTo(Hack::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
