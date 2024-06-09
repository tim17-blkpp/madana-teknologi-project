<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicProjectResource extends JsonResource
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
            'category' => $this->category->name,
            'client' => $this->client->name,
            'description' => $this->description,
            'url' => $this->url,
            'thumbnail_path' => $this->thumbnail_path,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            // 'galleries' => $this->galleries,
        ];
    }
}
