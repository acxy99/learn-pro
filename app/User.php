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

    protected $appends = ['role', 'teaching_courses', 'learning_courses'];

    protected $with = ['profile'];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function getRoleAttribute() {
        return $this->roles()->first(['id', 'name', 'title']);
    }

    public function teachingCourses() {
        return $this->belongsToMany(Course::class, 'course_instructor');
    }

    public function learningCourses() {
        return $this->belongsToMany(Course::class, 'course_learner');
    }

    public function getTeachingCoursesAttribute() {
        return $this->teachingCourses()->pluck('id');
    }

    public function getLearningCoursesAttribute() {
        return $this->learningCourses()->pluck('id');
    }
}
