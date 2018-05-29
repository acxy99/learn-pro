<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
    ];

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function getRouteKeyName() {
        return 'code';
    }
}
