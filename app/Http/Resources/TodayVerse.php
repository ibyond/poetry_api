<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodayVerse extends JsonResource
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
            'verse_id' => $this->verse_id,
            'timme' => $this->time,
            'verse' => new Verse($this->whenLoaded('verse')),
        ];
    }
}
