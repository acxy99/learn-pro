<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\Page;
use App\File;

use App\Http\Resources\PageResource;
use App\Http\Resources\PageResourceCollection;

use App\Http\Requests\StorePage;
use App\Http\Requests\UpdatePage;

class PageController extends Controller {

    public function index($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        
        $this->authorize('index', [Page::class, $course]);

        return view('admin.pages.index', ['course' => $course]);
    }

    public function apiIndex(Request $request, $course_id) {
        $course = Course::find($course_id);
        $searchKeyword = $request->query('searchInput');

        $pages = $course->pages()->searchByTitle($searchKeyword)->paginate(10);

        return new PageResourceCollection($pages); 
    }

    public function create($course_slug) {
        $course = Course::findBySlugOrFail($course_slug);

        $this->authorize('create', [Page::class, $course]);

        $parents = Page::where([
            'course_id' => $course->id,
        ])->get(['title', 'id'])->each->setAppends([]);
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

        $this->authorize('show', $page);

        return view('admin.pages.show', ['course' => $course, 'page' => $page]);
    }

    public function edit($course_slug, $page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
        ])->firstOrFail();

        $this->authorize('update', $page);

        $parents = Page::where([
            'course_id' => $course->id,
            ['id', '!=', $page->id],
        ])->get(['title', 'id'])->each->setAppends([]);
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
        $course = Course::find($page->course_id);

        $this->authorize('delete', $page);

        $page->delete();

        return response()->json(['page' => $page]);
    }

    public function uploadImage(Request $request) {
        $file = $request->file('file');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $courseSlug = $request->course_slug;

        $folderPath = 'courses/' . $courseSlug . '/resources';
        $fileName = $originalFileName . '.' . $originalExtension;
        Storage::putFileAs($folderPath, $file,  $fileName);

        $fullPath = Storage::url($folderPath . '/' . $fileName);

        return response()->json(['path' => $fullPath]);
    }
}
