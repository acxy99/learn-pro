<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Course extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'code',
        'title',
        'description',
        'slug',
    ];

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getImageAttribute($value) {
        return '/storage/courses/' . $value;
    }
}
