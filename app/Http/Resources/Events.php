<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Events extends JsonResource
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
            'description' => $this->description,
            'start_date' => Carbon::create($this->start_date)->format('d-m-Y H:i:s'),
            'end_date' => Carbon::create($this->end_date)->format('d-m-Y H:i:s'),
            'organizers' => $this->organizers
        ];
    }
}
