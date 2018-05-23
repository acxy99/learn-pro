<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Resources\PageResource;

class PageController extends Controller {

    public function index() {
        $pages = Page::paginate(5);

        return view('pages.index', ['pages' => $pages]);
    }

    public function create($course_id) {
        $page = new Page;

        return view('pages.create', ['page' => $page, 'course_id' => $course_id]);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->fill($request->all());
        $page->save();

        return view('pages.show', ['page' => $page]);
    }

    public function show($course_id, $page_id) {
        $page = Page::findOrFail($page_id);

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
