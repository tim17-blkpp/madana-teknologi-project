<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'category' => $this->category,
            'client' => $this->client,
            'description' => $this->description,
            'url' => $this->url,
            'thumbnail_path' => $this->thumbnail_path,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'show_on_landing_page' => $this->show_on_landing_page
            // 'galleries' => $this->galleries,
        ];
    }
}
