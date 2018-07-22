<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Http\Resources\CourseResourceCollection;

use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

class CategoryController extends Controller {

    public function index() {
        $this->authorize('index', Category::class);

        return view('admin.categories.index');
    }

    public function apiIndex(Request $request) {
        $categories = Category::
            when($request->query('searchInput'), function($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->query('searchInput').'%');
            })
            ->paginate(10);

        return new CategoryResourceCollection($categories);
    }

    public function create() {
        $this->authorize('create', Category::class);

        $category = new Category;

        return view('admin.categories.create', ['category' => $category]);
    }

    public function store(StoreCategory $request) {
        $this->authorize('create', Category::class);

        $category = new Category();
        $category->fill($request->except('image'));

        $category->save();
        
        if($request->hasFile('image')) {
            $category->image = 'category-' . $category->id . '.jpg';
            $request->file('image')->storeAs('public/categories', $category->image);
            $category->save();
        }

        return response()->json(['category' => $category]);
    }

    public function show($slug) {
        $category = Category::findBySlugOrFail($slug);

        $this->authorize('index', $category);

        return view('admin.categories.show', ['category' => $category]);
    }

    public function apiShow($id) {
        $category = Category::find($id);

        return new CategoryResource($category);
    }

    public function apiCourses($id) {
        $category = Category::findOrFail($id);

        return new CourseResourceCollection (
            $category->courses()->paginate(5)
        );
    }

    public function edit($slug) {
        $category = Category::findBySlugOrFail($slug);

        $this->authorize('update', $category);

        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(UpdateCategory $request, $id) {
        $category = Category::findOrFail($id);
        $category->slug = null;
        $category->fill($request->except('image'));

        $this->authorize('update', $category);

        if ($request->hasImage == 'true') {
            if ($request->hasFile('image')) {
                $category->image = 'category-' . $category->id . '.jpg';
                $request->file('image')->storeAs('public/categories', $category->image);
            }
        } else {
            if ($category->image)
                Storage::delete('public/categories/' . $category->image);
            $category->image = null;
        }

        $category->save();

        return response()->json(['category' => $category]);
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);

        $this->authorize('delete', $category);

        if ($category->image)
            Storage::delete('public/categories/' . $category->image);
        $category->courses()->detach();

        $category->delete();

        return response()->json(['category' => $category]);
    }
}
