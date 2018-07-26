<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'title',
        'description',
        'slug',
    ];

    protected $appends = [
        'image_path',
    ];

    public function courses() {
        return $this->belongsToMany(Course::class);
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getImagePathAttribute() {
        if ($this->image) {
            return Storage::url('categories/' . $this->image);
        } else {
            return Storage::url('categories/placeholder-image.png');
        }
    }
}
