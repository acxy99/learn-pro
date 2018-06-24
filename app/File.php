<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'course_id',
    ];

    protected $appends = [
        'file_path',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function getFilePathAttribute() {
        $course = $this->course;
        return '/storage/courses/' . $course->slug . '/' . $this->name;
    }
}
