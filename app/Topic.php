<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Course;
use App\Pla;

class Topic extends Model
{
    //
    use SearchableTrait;

    protected $fillable = ['custom_index',
                            'title',
                            'difficulity', 
                            'course_id',
                            'num_ques',
                            'passing_mark',];

    protected $searchable = [

        'columns' => [
            'topics.title' => 10,
            'topics.difficulity' => 10,
            'topics.custom_index' => 5,
            'topics.passing_mark' => 5,
            'topics.num_ques' => 5
        ]
    ];

    protected $appends = [
        'pages_count',
        'files_count',
        'pla_count',
    ];


    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function files(){

        return $this->hasMany(File::class);
    }
    
    public function pages(){

        return $this->hasMany(Page::class);
    }

    public function pla(){
        return $this->hasMany(Pla::class);
    }

    public function getPlaCountAttribute() {
        return $this->pla()->count();
    }

    public function getFilesCountAttribute() {
        return $this->files()->count();
    }

    public function getPagesCountAttribute() {
        return $this->pages()->count();
    }
}
