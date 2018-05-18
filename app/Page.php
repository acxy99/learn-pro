<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'body',
        'course_id',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
