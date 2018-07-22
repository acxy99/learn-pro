<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;
use App\File;

use App\Http\Resources\CourseResourceCollection;
use App\Http\Resources\PageResourceCollection;
use App\Http\Resources\FileResourceCollection;

class CourseController extends Controller {

    public function index() {
        return view('frontend.courses.index');
    }

    public function apiIndex(Request $request) {
        $searchKeyword = $request->query('searchInput');

        $courses = Course::searchByCode($searchKeyword)->searchByTitle($searchKeyword)->paginate(9);

        return new CourseResourceCollection($courses);
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('frontend.courses.show', ['course' => $course]);
    }

    public function apiPages($course_id) {
        return new PageResourceCollection(
            Page::where([
                'course_id' => $course_id,
                'parent_id' => null,
            ])->paginate(10)
        ); 
    }

    public function apiFiles($course_id) {
        return new FileResourceCollection(
            File::where([
                'course_id' => $course_id,
            ])->paginate(10)
        ); 
    }
}
