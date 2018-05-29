<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PageResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'data' => ['course' => $this->course,]
        ];
    }
}
