<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Course;
use App\Http\Resources\CourseResource;
use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;

class CourseController extends Controller {

    public function index() {
        return view('courses.index');
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('courses.show', ['course' => $course]);
    }
}
