<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

class CategoryController extends Controller {
    
    public function index() {
        return view('frontend.categories.index');
    }

    public function show($slug) {
        $category = Category::findBySlugOrFail($slug);

        return view('frontend.categories.show', ['category' => $category]);
    }

}
