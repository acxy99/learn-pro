<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Course;
use App\Page;
use App\Category;

use App\Http\Requests\StoreCourse;
use App\Http\Requests\UpdateCourse;

use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;

class CourseController extends Controller {
    
    public function index() {
        return view('admin.courses.index');
    }

    public function apiIndex(Request $request) {
        $user = User::find($request->get('user_id'));
        if ($user->isAn('admin')) {
            $courses = Course::paginate(10);
        } else {
            $courses = $user->teachingCourses()->paginate(10);
        }
        return new CourseResourceCollection($courses); 
    }

    public function create() {
        $course = new Course;
        $categories = Category::get(['id', 'title'])->each->setAppends([]);
        $instructors = User::whereIs('instructor')->get(['id', 'username']);

        return view('admin.courses.create', ['course' => $course, 'categories' => $categories, 'instructors' => $instructors]);
    }

    public function store(StoreCourse $request) {
        $course = new Course();
        $course->fill($request->except('image'));

        if($request->hasFile('image')) {
            $course->image = str_slug($course->code) . '.jpg';
            $request->file('image')->storeAs('public/courses', $course->image);
        }
        
        $course->save();

        $categories = $request->categories ? array_map('intval', explode(',', $request->categories)) : [];
        $course->categories()->sync($categories);

        $instructors = $request->instructors ? array_map('intval', explode(',', $request->instructors)) : [];
        $course->instructors()->sync($instructors);

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

    public function apiShow($id) {
        return new CourseResource(Course::find($id));
    }

    public function edit($slug) {
        $course = Course::findBySlugOrFail($slug);
        $categories = Category::get(['id', 'title'])->each->setAppends([]);
        $instructors = User::whereIs('instructor')->get(['id', 'username']);

        return view('admin.courses.edit', ['course' => $course, 'categories' => $categories, 'instructors' => $instructors]);
    }

    public function update(UpdateCourse $request, $id) {
        $course = Course::find($id);
        $course->fill($request->except('image'));

        if ($request->hasImage == 'true') {
            if ($request->hasFile('image')) {
                $course->image = str_slug($course->code) . '.jpg';
                $request->file('image')->storeAs('public/courses', $course->image);
            }
        } else {
            if ($course->image)
                Storage::delete('public/courses/' . $course->image);
            $course->image = null;
        }
         
        $course->save();

        $categories = $request->categories ? array_map('intval', explode(',', $request->categories)) : [];
        $course->categories()->sync($categories);

        $instructors = $request->instructors ? array_map('intval', explode(',', $request->instructors)) : [];
        $course->instructors()->sync($instructors);

        return response()->json(['course' => $course]);
    }

    public function destroy($id) {
        $course = Course::find($id);

        if ($course->image)
            Storage::delete('public/courses/' . $course->image);
        $course->categories()->detach();
        
        $course->delete();

        return response()->json(['course' => $course]);
    }
}
