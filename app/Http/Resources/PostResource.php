<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        // return parent::toArray($request);
        return [
            'id'            => $this->when($this->id, $this->id),
            'title'         => $this->when($this->title, $this->title),
            'description'   => $this->when($this->description, $this->description),
            'status'        => $this->when($this->published_at, $this->published_at),
            'website' => [
                'name'  => $this->when(optional($this->website)->name, optional($this->website)->name),
                'url' => $this->when(optional($this->website)->url, optional($this->website)->url),
            ],

        ];
    }
}
