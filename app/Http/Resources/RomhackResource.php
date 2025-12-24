<?php

namespace App\Http\Resources;

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RomhackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'starcount' => $this->versions->max('starcount'),
            'megapack' => $this->megapack,
            'downloads' => $this->versions->sum('downloadcount'),
            'releasedate' => $this->versions->where('demo', 0)->min('releasedate'),
            'versions' => VersionResource::collection($this->whenLoaded('versions')),
            'tags' => RomhacktagsResource::collection($this->whenLoaded('romhacktags'))
        ];
    }
}
