<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Course extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use SearchableTrait;

    protected $searchable = [

        'columns' => [
            'courses.code' => 10,
            'courses.title' => 10,
        ]
    ];

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
        'topic_count',
        'pla_count',
        'leap_count',
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

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function topic(){
        return $this->hasMany(Topic::class);
    }

    public function pla(){
        return $this->hasMany(Pla::class);
    }

    public function leap(){
        return $this->hasMany(Leap::class);
    }



    public function getInstructorsAttribute() {
        return $this->instructors()->get(['id', 'username', 'email'])->each->setAppends([]);
    }

    public function getCoInstructorsAttribute() {
        return $this->instructors()->where('id', '!=', $this->owner_id)->get(['id', 'username', 'email'])->each->setAppends([]);
    }

    public function getTopicCountAttribute(){
        return $this->topic()->count();
    }

    public function getPagesCountAttribute() {
        return $this->pages()->count();
    }

    public function getFilesCountAttribute() {
        return $this->files()->count();
    }

    public function getPlaCountAttribute() {
        return $this->pla()->count();
    }

    public function getLeapCountAttribute() {
        return $this->leap()->count();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($course) {
            $course->instructors()->detach();
            $course->learners()->detach();
            $course->categories()->detach();
            $course->pages()->delete();
            $course->files()->delete();
            $course->topic()->delete();
            $course->pla()->delete();
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
            return Storage::url('courses/' . $this->code . '/' . $this->image);
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
