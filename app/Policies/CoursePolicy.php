<?php

namespace App\Policies;

use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy {
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->isAn('admin') || $user->isAn('instructor');
    }

    public function show(User $user, Course $course) {
        return $user->isAn('admin') || $user->teachingCourses->contains($course->id);
    }

    public function create(User $user) {
        return $user->isAn('admin') || $user->isAn('instructor');
    }

    public function update(User $user, Course $course) {
        return $user->isAn('admin') || $user->teachingCourses->contains($course->id);
    }

    public function delete(User $user, Course $course) {
        return $user->isAn('admin') || $user->teachingCourses->contains($course->id);
    }
}
