<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Page;

class PageController extends Controller {

    public function index() {
        $pages = Page::paginate(5);

        return view('pages.index', ['pages' => $pages]);
    }

    public function show($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        return view('pages.show', ['course' => $course, 'page' => $page]);
    }
}
