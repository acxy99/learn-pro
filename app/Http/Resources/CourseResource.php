<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CourseResource extends Resource
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
        // return [
        //     'id' => $this->id,
        //     'code' => $this->code,
        //     'title' => $this->title,
        //     'description' => $this->description,
        // ];
    }

    public function with($request)
    {
        return [
            'data' => ['pages' => $this->pages,]
        ];
    }
}
