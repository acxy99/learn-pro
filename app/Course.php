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

    protected $appends = [
        'image_path',
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
                'source' => 'code'
            ]
        ];
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getImagePathAttribute() {
        return '/storage/courses/' . $this->image;
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($course) {
             $course->pages()->delete();
        });
    }
}
