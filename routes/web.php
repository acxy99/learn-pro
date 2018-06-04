<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('/categories', 'CategoryController');

Route::resource('/courses', 'CourseController');

Route::resource('/pages', 'PageController', ['except' => ['create','show']]);
Route::get('/courses/{course_slug}/pages/create', 'PageController@create');
Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');
