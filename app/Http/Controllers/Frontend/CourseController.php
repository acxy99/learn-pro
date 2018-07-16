<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;

class CourseController extends Controller {

    public function index() {
        return view('frontend.courses.index');
    }

    public function apiIndex(Request $request) {
        $courses = Course::
            when($request->query('searchInput'), function($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->query('searchInput').'%');
            })
            ->paginate(9);

        return new CourseResourceCollection($courses);
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('frontend.courses.show', ['course' => $course]);
    }
}
