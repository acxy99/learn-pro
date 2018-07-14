<?php

namespace App\Policies;

use App\User;
use App\Course;
use App\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy {
    use HandlesAuthorization;

    public function index(User $user, Course $course) {
        return $user->isAn('admin') || $user->teaching_courses->contains($course->id);
    }

    public function show(User $user, Page $page) {
        return $user->isAn('admin') || $user->teaching_courses->contains($page->course_id);
    }

    public function create(User $user, Course $course) {
        return $user->isAn('admin') || $user->teaching_courses->contains($course->id);
    }

    public function update(User $user, Page $page) {
        return $user->isAn('admin') || $user->teaching_courses->contains($page->course_id);
    }

    public function delete(User $user, Page $page) {
        return $user->isAn('admin') || $user->teaching_courses->contains($page->course_id);
    }
}
