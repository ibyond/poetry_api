<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Poet extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'dynasty_name' => $this->dynasty_name,
            'dynasty_id' => $this->dynasty_id,
            'desc' => $this->desc,
            'content' => $this->content,
            'star' => $this->star,
        ];
    }
}
