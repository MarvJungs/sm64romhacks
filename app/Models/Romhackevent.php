<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Stringable;

class Romhackevent extends Model
{
    use HasSEO;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_utc',
        'end_utc',
        'external',
        'external_url'
    ];

    protected function casts(): array
    {
        return [
            'description' => 'json',
            'external' => 'boolean'
        ];
    }

    /**
     * Get the route key for the model.
     * 
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->name,
            description: $this->getDescriptionForSEOTags(),
        );
    }

    public function getDescriptionForSEOTags(): Stringable | null
    {
        $descriptionObject = $this->description;
        if ($descriptionObject === null) {
            return null;
        }
        $blocks = Arr::get($descriptionObject, 'blocks');
        $data = Arr::flatten(Arr::pluck($blocks, 'data'));
        $description = Arr::join($data, '. ');
        return Str::of($description)->stripTags();
    }
}
