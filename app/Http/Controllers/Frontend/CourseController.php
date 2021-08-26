<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;
use App\File;
use App\LearnerCourses;

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

    public function apiPages(Request $request, $course_id) {
        $course = Course::find($course_id);
        $searchKeyword = $request->query('searchInput');

        $pages = $course->pages()->roots()->searchByTitle($searchKeyword)->paginate(10);

        return new PageResourceCollection($pages); 
    }

    public function apiFiles(Request $request, $course_id) {
        $course = Course::find($course_id);
        $searchKeyword = $request->query('searchInput');

        $files = $course->files()->searchByName($searchKeyword)->paginate(10);

        return new FileResourceCollection($files); 
    }

    public function apiNew() {
        $courses = Course::orderBy('created_at', 'desc')->take(4)->get();

        return new CourseResourceCollection($courses);
    }
}
