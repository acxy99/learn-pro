<?php

namespace App;

use App\Topic;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Pla extends Model
{

    use SearchableTrait;

    protected $searchable = [

        'columns' => [
            'plas.question' => 10,
            'plas.qtype' => 10,
            'plas.status' => 5,
            'pla.mark' =>5
        ]
    ];
    protected $fillable = [
        'topic_id',
        'course_id',
        'question',
        'options',
        'status',
        'mark',
        'qtype',
        'answers'
    ];

    protected $cast = [

        'options' =>'array',
        'answers' => 'array'
    ];   

    
    public function setOptionsAttribute($value)
	{
	    $this->attributes['options'] = json_encode($value);
	}

    public function setAnswersAttribute( $value ) {
        $this->attributes['answers'] = json_encode( $value );
    }
}
