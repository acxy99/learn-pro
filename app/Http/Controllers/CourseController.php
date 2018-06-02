<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Http\Resources\CourseResource;
use App\Page;

class CourseController extends Controller {

    public function index() {
        return view('courses.index');
    }

    public function create() {
        $course = new Course();

        return view('courses.create', ['course' => $course]);
    }

    public function store(Request $request) {
        $course = new Course();
        $course->fill($request->except('image'));
        $course->image = 'placeholder-image.png';
        $course->save();

        if($request->hasFile('image')) {
            $course->image = $course->slug . '.jpg';
            $request->file('image')->storeAs('public/courses', $course->image);
            $course->save();
        }
        
        return redirect()->route('courses.show', $course->slug);
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('courses.show', ['course_id' => $course->id]);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        // update slug
    }

    public function destroy($id) {
        //
    }
}
