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
        $page = new Page;
        $course = Course::findBySlugOrFail($course_slug);
        $parents = Page::where('course_id', $course->id)->where('parent_id', null)->select('title', 'id')->get();

        return view('pages.create', ['page' => $page, 'course' => $course, 'parents' => $parents]);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->fill($request->all());
        $page->save();

        return response()->json(['page' => $page]);
    }

    public function show($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = Page::where('slug', $page_slug)->where('course_id', $course->id)->firstOrFail();

        return view('pages.show', ['page_id' => $page->id]);
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
