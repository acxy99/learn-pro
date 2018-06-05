<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Page;
// use App\Http\Resources\PageResourceCollection;

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
        /*$pages = $this->pages()->where('parent_id', null)->get();
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'image_path' => $this->image_path,
            'slug' => $this->slug,
            'pages' => new PageResourceCollection($pages),
        ];*/
    }
}
