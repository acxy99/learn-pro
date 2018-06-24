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
        'pages_count',
        'files_count',
    ];

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function files() {
        return $this->hasMany(File::class);
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

    public function getImagePathAttribute() {
        if ($this->image) {
            return '/storage/courses/' . $this->image;
        } else {
            return '/storage/courses/placeholder-image.png';
        }
    }

    public function getPagesCountAttribute() {
        return $this->pages()->count();
    }

    public function getFilesCountAttribute() {
        return $this->files()->count();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($course) {
             $course->pages()->delete();
             $course->files()->delete();
        });
    }
}
