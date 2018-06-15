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

Route::get('/admin', function() { return view('admin.index'); });

// Route::resource('/categories', 'CategoryController');

Route::resource('/courses', 'CourseController');

/*Route::resource('/pages', 'PageController')->except([
    'index', 'create', 'show', 'edit'
]);*/
Route::get('/courses/{course_slug}/pages/create', 'PageController@create');
Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');
Route::get('/courses/{course_slug}/pages/{page_slug}/edit', 'PageController@edit');

Route::get('/courses/{course_slug}/files/create', 'FileController@create');