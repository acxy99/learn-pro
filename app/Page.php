<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Page extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'title',
        'body',
        'course_id',
        'parent_id',
        'slug',
        'topic_id'
    ];

    protected $appends = ['children'];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function root() {
        if($this->parent) {
            return $this->parent->root();
        }
        return $this;
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($page) {
             $page->children()->delete();
        });
    }

    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug) {
        $course = $model->course;

        return $query->where('course_id', $course->getKey());
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getChildrenAttribute() {
        return $this->children()->get();
    }

    public function scopeRoots($query) {
        return $query->where('parent_id', null);
    }

    public function scopeSearchByTitle($query, $title) {
        return $query->when($title, function($query) use ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
        });
    }
}
