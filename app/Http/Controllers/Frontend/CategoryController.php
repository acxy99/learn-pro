<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Http\Resources\CourseResourceCollection;

class CategoryController extends Controller {
    
    public function index() {
        return view('frontend.categories.index');
    }

    public function apiIndex(Request $request) {
        $searchKeyword = $request->query('searchInput');
        $categories = Category::searchByTitle($searchKeyword)->paginate(9);

        return new CategoryResourceCollection($categories);
    }

    public function show($slug) {
        $category = Category::findBySlugOrFail($slug);

        return view('frontend.categories.show', ['category' => $category]);
    }

    public function apiCourses($category_id) {
        $category = Category::findOrFail($category_id);
        
        return new CourseResourceCollection (
            $category->courses()->paginate(9)
        );
    }

    public function apiPopular() {
        $categories = Category::withCount('courses')->orderBy('courses_count', 'desc')->take(4)->get();

        return new CategoryResourceCollection($categories);
    }
}
