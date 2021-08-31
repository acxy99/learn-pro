<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;
use App\File;
use App\User;
use App\Topic;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function apiPages(Request $request, $topic_id) {
        $topic = TOpic::find($topic_id);
        $searchKeyword = $request->query('searchInput');

        $pages = $topic->pages()->roots()->searchByTitle($searchKeyword)->paginate(10);

        return new PageResourceCollection($pages); 
    }

    public function apiFiles(Request $request, $topic_id) {
        $topic = Topic::find($topic_id);
        $searchKeyword = $request->query('searchInput');

        $files = $topic->files()->searchByName($searchKeyword)->paginate(10);

        return new FileResourceCollection($files); 
    }

    public function apiNew() {
        $courses = Course::orderBy('created_at', 'desc')->take(4)->get();

        return new CourseResourceCollection($courses);
    }

    public function takeCourse ($course_slug){

        $course = Course::findBySlugOrFail($course_slug);

        $user = Auth::user();

        DB::insert('insert into course_learner (course_id, user_id ) values (?, ?)', [$course->id, $user->id]);
        

        return view('frontend.mycourse.index');
    }

    public function viewMyCourses() {
        


        return view('frontend.mycourse.index');
    }

    public function apiMyCourses(Request $request,$id) {

        $user = User::find($id);

        $searchKeyword = $request->query('searchInput');

        $courses = $user->learningCourses()->search($searchKeyword)->paginate(9);;


        return new CourseResourceCollection($courses);
    }


}
