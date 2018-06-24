<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;

class PageController extends Controller {

    public function show($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        return view('frontend.pages.show', ['course' => $course, 'page' => $page]);
    }
}
