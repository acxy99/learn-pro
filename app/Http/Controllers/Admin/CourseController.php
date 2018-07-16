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
        $this->authorize('view', Course::class);

        return view('admin.courses.index');
    }

    public function apiIndex(Request $request) {
        $user = User::find($request->get('user_id'));
        if ($user->isAn('admin')) {
            $courses = Course::
                when($request->query('searchInput'), function($query) use ($request) {
                    return $query->where('title', 'like', '%'.$request->query('searchInput').'%');
                })
                ->paginate(10);
        } else {
            $courses = $user->teachingCourses()
                ->when($request->query('searchInput'), function($query) use ($request) {
                    return $query->where('title', 'like', '%'.$request->query('searchInput').'%');
                })
                ->paginate(10);;
        }
        return new CourseResourceCollection($courses); 
    }

    public function create() {
        $this->authorize('create', Course::class);

        $course = new Course;
        $instructors = User::whereIs('instructor')->get(['id', 'username'])->each->setAppends([]);
        $categories = Category::get(['id', 'title'])->each->setAppends([]);

        return view('admin.courses.create', ['course' => $course, 'instructors' => $instructors, 'categories' => $categories]);
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
   
        $owner = [(int)$request->owner_id];
        $coInstructors = $request->co_instructors_id ? array_map(
            create_function('$value', 'return (int)$value;'),
            $request->co_instructors_id
        ) : [];
        $instructors = array_merge($owner, $coInstructors);

        $course->instructors()->sync($instructors);

        return response()->json(['course' => $course]);
    }

    public function show($slug) {
        $course = Course::findBySlugOrFail($slug);

        $this->authorize('show', $course);
        
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

        $this->authorize('update', $course);

        $instructors = User::whereIs('instructor')->get(['id', 'username'])->each->setAppends([]);
        $categories = Category::get(['id', 'title'])->each->setAppends([]);

        return view('admin.courses.edit', [
            'course' => $course, 
            'instructors' => $instructors, 
            'categories' => $categories, 
        ]);
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

        $owner = [(int)$request->owner_id];
        $coInstructors = $request->co_instructors_id ? array_map(
            create_function('$value', 'return (int)$value;'),
            $request->co_instructors_id
        ) : [];
        $instructors = array_merge($owner, $coInstructors);
        $course->instructors()->sync($instructors);

        return response()->json(['course' => $course]);
    }

    public function destroy($id) {
        $course = Course::find($id);

        $this->authorize('delete', $course);

        if ($course->image)
            Storage::delete('public/courses/' . $course->image);
        
        $course->delete();

        return response()->json(['course' => $course]);
    }
}
