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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'course_id' => $this->course_id,
            'parent_id' => $this->parent_id,
            'children' => $this->children,
            'slug' => $this->slug,
        ];
    }
}
