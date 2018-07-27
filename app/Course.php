<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'code',
        'title',
        'description',
        'slug',
        'owner_id',
    ];

    protected $appends = [
        'image_path',
        'pages_count',
        'files_count',
        'categories',
        'instructors',
        'co_instructors'
    ];

    protected $with = ['owner'];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function instructors() {
        return $this->belongsToMany(User::class, 'course_instructor');
    }

    public function learners() {
        return $this->belongsToMany(User::class, 'course_learner');
    }

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function getInstructorsAttribute() {
        return $this->instructors()->get(['id', 'username', 'email'])->each->setAppends([]);
    }

    public function getCoInstructorsAttribute() {
        return $this->instructors()->where('id', '!=', $this->owner_id)->get(['id', 'username', 'email'])->each->setAppends([]);
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
            $course->instructors()->detach();
            $course->learners()->detach();
            $course->categories()->detach();
            $course->pages()->delete();
            $course->files()->delete();
        });
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function getCategoriesAttribute() {
        return $this->categories()->get(['id', 'title', 'slug'])->each->setAppends([]);
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
            return Storage::url('courses/' . $this->slug . '/' . $this->image);
        } else {
            return Storage::url('courses/placeholder-image.png');
        }
    }

    public function scopeSearchByCode($query, $code) {
        return $query->when($code, function($query) use ($code) {
            return $query->orWhere('code', 'like', '%' . $code . '%');
        });
    }

    public function scopeSearchByTitle($query, $title) {
        return $query->when($title, function($query) use ($title) {
            return $query->orWhere('title', 'like', '%' . $title . '%');
        });
    }
}
