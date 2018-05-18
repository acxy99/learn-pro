<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Http\Resources\Course as CourseResource;

class CourseController extends Controller {

    public function index() {
        $courses = Course::paginate(5);

        //return CourseResource::collection($courses);
        return view('courses.index', ['courses' => $courses]);
    }

    public function create() {
        $course = new Course();

        // return create form
    }

    public function store(Request $request) {
        $course = new Course();
        $course->fill($request->all());
        $course->save();
        
        // redirect to index
    }

    public function show($id) {
        $course = Course::findOrFail($id);

        return new CourseResource($course);
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
