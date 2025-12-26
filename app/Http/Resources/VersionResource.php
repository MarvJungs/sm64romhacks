<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
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
            'hack' => $this->romhack->name,
            'name' => $this->name,
            'starcount' => $this->starcount,
            'downloads' => $this->downloadcount,
            'filename' => $this->filename,
            'authors' => AuthorResource::collection($this->whenLoaded('authors'))
        ];
    }
}
