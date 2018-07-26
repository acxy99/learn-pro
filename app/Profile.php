<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'gender', 
        'date_of_birth',
        'phone',
        'country',
        'picture',
    ];

    protected $appends = [
        'picture_path',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'user.username'
            ]
        ];
    }

    public function getPicturePathAttribute() {
        // if ($this->picture) {
        //     return Storage::url('profiles/' . $this->picture);
        // } else {
        //     return Storage::url('profiles/default-profile-picture.jpg');
        // }
        return 'testing';
    }
}
