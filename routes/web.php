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

/*
    Admin
*/
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/', function() { return view('admin.dashboard'); })->name('dashboard');

    Route::resource('/courses', 'CourseController');

    Route::get('/courses/{id}/pages', 'PageController@index');
    Route::get('/courses/{course_slug}/pages/create', 'PageController@create');
    Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');
    Route::get('/courses/{course_slug}/pages/{page_slug}/edit', 'PageController@edit');
});

/*
    Frontend
*/
Route::resource('/courses', 'CourseController')->only(['index', 'show']);

Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');

Route::get('/courses/{course_slug}/files/create', 'FileController@create');