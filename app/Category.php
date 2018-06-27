<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

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
            return '/storage/categories/' . $this->image;
        } else {
            return '/storage/categories/placeholder-image.png';
        }
    }
}
