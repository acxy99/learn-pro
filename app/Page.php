<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'body',
        'course_id',
        'parent_id',
    ];

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
}
