<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Resources\PageResource;
use App\Course;
use App\Http\Requests\StorePage;
use App\Http\Requests\UpdatePage;
use App\File;

class PageController extends Controller {

    public function index() {
        $pages = Page::paginate(5);

        return view('pages.index', ['pages' => $pages]);
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        $parents = Page::where([
            'course_id' => $course->id,
            // 'parent_id'=> null,
        ])->select('title', 'id')->get();

        $files = File::where('course_id', $course->id)->get();
        $page = new Page;

        return view('pages.create', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page]);
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

        return view('pages.show', ['course' => $course, 'page' => $page]);
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
        
        return view('pages.edit', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page]);
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
