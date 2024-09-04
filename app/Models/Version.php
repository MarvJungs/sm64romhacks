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
        'recommened',
        'demo'
    ];

    public function hack(): BelongsTo
    {
        return $this->belongsTo(Hack::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function getAuthorList(): string
    {
        $authors = $this->authors;
        $authorsList = '';
        foreach ($authors as $author) {
            if ($author->user) {
                $authorsList .= '<a href="' . route('users.show', $author->user) . '">' . $author->name . '</a>, ';
            } else {
                $authorsList .= $author->name . ', ';
            }
        }
        $authorsList = substr($authorsList, 0, strlen($authorsList) - 2);
        return $authorsList;
    }
}
