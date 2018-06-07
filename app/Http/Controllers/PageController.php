<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Resources\PageResource;
use App\Course;

class PageController extends Controller {

    public function index() {
        $pages = Page::paginate(5);

        return view('pages.index', ['pages' => $pages]);
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $parents = Page::where('course_id', $course->id)->where('parent_id', null)->select('title', 'id')->get();
        $page = new Page;

        return view('pages.create', ['course' => $course, 'parents' => $parents, 'page' => $page]);
    }

    public function store(Request $request) {
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

        return view('pages.show', ['course' => $course, 'page' => $page]);
    }

    public function edit($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        
        $parents = Page::where([
            'course_id' => $course->id,
            'parent_id' => null,
        ])->get();
        
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        return view('pages.edit', ['course' => $course, 'parents' => $parents, 'page' => $page]);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);
        $page->slug = null;
        $page->fill($request->all());
        $page->save();

        return response()->json(['page' => $page]);
    }

    public function destroy($id) {
        //
    }
}
