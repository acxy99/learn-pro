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

    public function create($course_code) {
        $page = new Page;
        $course = Course::where('code', $course_code)->firstOrFail();

        return view('pages.create', ['page' => $page, 'course_id' => $course->id]);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->fill($request->all());
        $page->save();

        return view('pages.show', ['page' => $page]);
    }

    public function show($course_code, $page_id) {
        $course = Course::where('code', $course_code)->firstOrFail();
        $page = Page::where('id', $page_id)->where('course_id', $course->id)->firstOrFail();

        return view('pages.show', ['page' => $page]);
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
