<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller {

    public function index() {
        return view('categories.index');
    }

    public function create() {
        $category = new Category();

        return view('categories.create', ['category' => $category]);
    }

    public function store(Request $request) {
        $category = new Category();
        $category->fill($request->except('image'));
        $category->image = 'placeholder-image.png';
        $category->save();

        if($request->hasFile('image')) {
            $category->image = 'category_' . $category->id . '.jpg';
            $request->file('image')->storeAs('public/categories', $category->image);
            $category->save();
        }
        
        return view('categories.show', ['category' => $category]);
    }

    public function show($id) {
        $category = Category::findOrFail($id);

        return view('categories.show', ['category' => $category]);
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
