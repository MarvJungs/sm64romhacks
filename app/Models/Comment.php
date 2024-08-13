<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hack_id',
        'title',
        'text'
    ];

    public function hack()
    {
        return $this->belongsTo(Hack::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
