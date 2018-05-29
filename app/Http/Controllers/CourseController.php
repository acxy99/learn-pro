<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Http\Resources\CourseResource;

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
            $course->image = 'course_' . $course->id . '.jpg';
            $request->file('image')->storeAs('public/courses', $course->image);
            $course->save();
        }
        
        return view('courses.show', ['course' => $course]);
    }

    public function show($code) {
        // $course = Course::findOrFail($id);
        $course = Course::where('code', $code)->firstOrFail();

        return view('courses.show', ['course' => $course]);
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
