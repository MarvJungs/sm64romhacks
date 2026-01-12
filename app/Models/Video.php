<?php

namespace App\Models;

use Google_Client;
use Google_Service_YouTube;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $fillable = ['link', 'thumbnail'];
    public function run() : BelongsTo
    {
        return $this->belongsTo(Run::class);
    }

    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function videoID(): Attribute
    {
        return new Attribute(
            get: function () {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->link, $match);
                $id = $match[1];
                return $id;
            }
        );
    }
}
