<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeapResult extends Model
{
    protected $table = "leap_results";

    protected $fillable = [ 'learner_id', 'answers', 'obtain_mark','learner_type','course_id'];


    protected $cast = [
        'answers' => 'array'
    ]; 
    
    public function setAnswersAttribute( $value ) {
        $this->attributes['answers'] = json_encode( $value );
    }
}
