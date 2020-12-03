<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Verse extends JsonResource
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
            'content' => $this->content,
            'poet_id' => $this->poet_id,
            'poet_name' => $this->poet_name,
            'poetry_id' =>$this->poetry_id,
            'poetry_name' =>$this->poetry_name,
            'star' => $this->star,
        ];
    }
}
