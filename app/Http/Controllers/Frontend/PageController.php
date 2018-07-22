<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;

class PageController extends Controller {

    public function show($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = $course->pages()->where(['slug' => $page_slug])->firstOrFail();

        return view('frontend.pages.show', ['course' => $course, 'page' => $page]);
    }
}
