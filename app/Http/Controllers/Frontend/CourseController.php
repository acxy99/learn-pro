<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;

class CourseController extends Controller {

    public function index() {
        return view('frontend.courses.index');
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('frontend.courses.show', ['course' => $course]);
    }
}
