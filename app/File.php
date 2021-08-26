<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Course;

class File extends Model
{
    protected $fillable = [
        'name',
        'course_id',
        'topic_id'
    ];

    protected $appends = [
        'file_path',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function getFilePathAttribute() {
        
        return Storage::url('courses/' . $this->course_id. '/files/' . $this->name);
    }

    public function scopeSearchByName($query, $name) {
        return $query->when($name, function($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }
}
