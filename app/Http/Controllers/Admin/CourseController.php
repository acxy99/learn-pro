<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;

use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;

class CourseController extends Controller {
    
    public function index() {
        $courses = Course::all();

        return view('admin.courses.index', ['courses' => $courses]);
    }

    public function create() {
        $course = new Course;

        return view('admin.courses.create', ['course' => $course]);
    }

    public function store(StoreCourse $request) {
        $course = new Course();
        $course->fill($request->except('image'));

        if($request->hasFile('image')) {
            $course->image = str_slug($course->code) . '.jpg';
            $request->file('image')->storeAs('public/courses', $course->image);
        } else {
            $course->image = 'placeholder-image.png';
        }
        
        $course->save();

        return response()->json(['course' => $course]);
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);
        
        $lastUpdatedPage = $course->pages()->orderBy('updated_at', 'desc')->pluck('updated_at')->first();
        $lastUpdatedFile = $course->files()->orderBy('updated_at', 'desc')->pluck('updated_at')->first();

        return view('admin.courses.show', [
            'course' => $course, 
            'lastUpdatedPage' => $lastUpdatedPage,
            'lastUpdatedFile' => $lastUpdatedFile,
        ]);
    }

    public function edit($slug) {
        $course = Course::findBySlugOrFail($slug);

        return view('admin.courses.edit', ['course' => $course]);
    }

    public function update(UpdateCourse $request, $id) {
        $course = Course::find($id);
        $course->fill($request->except('image'));

        if($request->hasFile('image')) {
            $course->image = str_slug($course->code) . '.jpg';
            $request->file('image')->storeAs('public/courses', $course->image);
        }
        
        $course->save();

        return response()->json(['course' => $course]);
    }

    public function destroy($id) {
        $course = Course::find($id);
        $course->delete();

        return response()->json(['course' => $course]);
    }
}
