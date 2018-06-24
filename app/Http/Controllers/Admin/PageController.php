<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Page;
use App\File;

use App\Http\Requests\StorePage;
use App\Http\Requests\UpdatePage;

class PageController extends Controller {

    public function index($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        return view('admin.pages.index', ['course' => $course]);
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        $parents = Page::where([
            'course_id' => $course->id,
            // 'parent_id'=> null,
        ])->select('title', 'id')->get();

        $files = File::where('course_id', $course->id)->get();
        $page = new Page;

        return view('admin.pages.create', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page]);
    }

    public function store(StorePage $request) {
        $page = new Page;
        $page->fill($request->all());
        $page->save();

        return response()->json(['page' => $page]);
    }

    public function show($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        return view('admin.pages.show', ['course' => $course, 'page' => $page]);
    }

    public function edit($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        $parents = Page::where([
            'course_id' => $course->id,
            // 'parent_id' => null,
            ['id', '!=', $page->id],
        ])->select('title', 'id')->get();

        $files = File::where('course_id', $course->id)->get();
        
        return view('admin.pages.edit', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page]);
    }

    public function update(UpdatePage $request, $id) {
        $page = Page::find($id);
        $page->slug = null;
        $page->fill($request->all());
        $page->save();

        return response()->json(['page' => $page]);
    }

    public function destroy($id) {
        $page = Page::find($id);
        $page->delete();

        return response()->json(['page' => $page]);
    }
}
