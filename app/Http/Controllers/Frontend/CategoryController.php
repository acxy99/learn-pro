<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;

class CategoryController extends Controller {
    
    public function index() {
        return view('frontend.categories.index');
    }

    public function apiIndex(Request $request) {
        $categories = Category::
            when($request->query('searchInput'), function($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->query('searchInput').'%');
            })
            ->paginate(10);

        return new CategoryResourceCollection($categories);
    }

    public function show($slug) {
        $category = Category::findBySlugOrFail($slug);

        return view('frontend.categories.show', ['category' => $category]);
    }

}
