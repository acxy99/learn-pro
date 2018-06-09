<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'course_id',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
