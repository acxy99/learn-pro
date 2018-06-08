<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'course_id',
        'path',
        'slug',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug) {
        $course = $model->course;

        return $query->where('course_id', $course->getKey());
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
