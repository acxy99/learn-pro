<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Leap extends Model
{
    use SearchableTrait;

    protected $searchable = [

        'columns' => [
            'leaps.question' => 10,
            'leaps.qtype' => 10,
            'leaps.status' => 5
        ]
    ];
    
    protected $fillable = [
        'course_id',
        'question',
        'options',
        'status',
        'qtype',
    ];

    protected $cast = [

        'options' =>'array',
    ];   

    
    public function setOptionsAttribute($value)
	{
	    $this->attributes['options'] = json_encode($value);
	}

}
