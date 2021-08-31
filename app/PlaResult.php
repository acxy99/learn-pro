<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaResult extends Model
{
    protected $table = "pla_results";

    protected $fillable = [ 'learner_id', 'answers', 'obtain_mark','topic_id','is_pass'];


    protected $cast = [
        'answers' => 'array'
    ]; 
    
    public function setAnswersAttribute( $value ) {
        $this->attributes['answers'] = json_encode( $value );
    }
}
