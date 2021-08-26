<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\Page;
use App\File;
use App\Topic;

use App\Http\Resources\PageResource;
use App\Http\Resources\PageResourceCollection;

use App\Http\Requests\StorePage;
use App\Http\Requests\UpdatePage;

class PageController extends Controller {

    public function index($course_slug,$topic_id) {

        $course = Course::findBySlugOrFail($course_slug);

        $topic = Topic::find($topic_id);
        return view('admin.pages.index', ['course' => $course, 'topic'=>$topic]);
    }

    public function apiIndex(Request $request, $topic_id) {
        $topic = Topic::find($topic_id);
        $searchKeyword = $request->query('searchInput');

        $pages = $topic->pages()->searchByTitle($searchKeyword)->paginate(10);

        return new PageResourceCollection($pages); 
    }

    public function create($course_slug, $topic_id) {
        $course = Course::findBySlugOrFail($course_slug);

        $this->authorize('create', [Page::class, $course]);

        $topic = Topic::find($topic_id);

        $parents = Page::where([
            'course_id' => $course->id,
        ])->get(['title', 'id'])->each->setAppends([]);
        $files = File::where('course_id', $course->id)->get();
        $page = new Page;
        
        return view('admin.pages.create', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page, 'topic'=>$topic]);
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
        
        $topic = Topic::findOrFail($page->topic_id);
    

        $this->authorize('show', $page);

        return view('admin.pages.show', ['course' => $course, 'page' => $page, 'topic'=> $topic]);
    }

    public function edit($course_slug, $topic_id,$page_slug) {
        $course = Course::findBySlugOrFail($course_slug);
        $topic = Topic::find($topic_id);
        $page = Page::where([
            'course_id' => $course->id,
            'slug' => $page_slug,
            'topic_id' => $topic_id

        ])->firstOrFail();

        

        $this->authorize('update', $page);

        $parents = Page::where([
            'course_id' => $course->id,
            ['id', '!=', $page->id],
        ])->get(['title', 'id'])->each->setAppends([]);
        $files = File::where('course_id', $course->id)->get();
        
        return view('admin.pages.edit', ['course' => $course, 'parents' => $parents, 'files' => $files, 'page' => $page, 'topic'=>$topic]);
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

        $folderPath = 'courses/' . $courseSlug . '/page-resources';
        $fileName = $originalFileName . '.' . $originalExtension;
        Storage::putFileAs($folderPath, $file,  $fileName);

        $fullPath = Storage::url($folderPath . '/' . $fileName);

        return response()->json(['path' => $fullPath]);
    }
}
