<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->when($this->slug, $this->slug),
            'category_id' => $this->when($this->category_id, $this->category_id),
            'description' => $this->when($this->description, $this->description),
            'image_url' => $this->imageUrl(),
            'created_at_for_human' => $this->when($this->created_at, function () {
                return $this->created_at->diffForHumans();
            }),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
