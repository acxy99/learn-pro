<?php

namespace App\Policies;

use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function index(User $user, Course $course) {
        return $user->isAn('admin') || $user->teaching_courses->contains($course->id);
    }

    // public function create(User $user, Course $course) {
    //     return $user->isAn('admin') || $user->teaching_courses->contains($course->id);
    // }

    // public function update(User $user, File $file) {
    //     return $user->isAn('admin') || $user->teaching_courses->contains($file->course_id);
    // }

    // public function delete(User $user, File $file) {
    //     return $user->isAn('admin') || $user->teaching_courses->contains($file->course_id);
    // }
}
