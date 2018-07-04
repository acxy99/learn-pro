<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

use Bouncer;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'roles',
    ];

    public function getRolesAttribute() {
        return $this->roles()->get();
    }

    public function teachingCourses() {
        return $this->belongsToMany(Course::class, 'course_instructor');
    }

    public function learningCourses() {
        return $this->belongsToMany(Course::class, 'course_learner');
    }
}
