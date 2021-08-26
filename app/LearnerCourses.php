<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearnerCourses extends Model
{
    //

    protected $fillable =[

        'course_id',
        'learner_id',
        'category'

    ];

}
