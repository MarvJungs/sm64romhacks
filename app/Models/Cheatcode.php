<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheatcode extends Model
{
    protected $fillable = [
        'name',
        'description',
        'code'
    ];
}
