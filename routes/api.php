<?php

use Illuminate\Http\Request;
use App\Course;
use App\Http\Resources\Course as CourseResource;
use App\Page;
use App\Http\Resources\Page as PageResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('course', function() { return new CourseResource(Course::paginate(5)); });
//Route::get('course/{id}', 'CourseController@show');
//Route::post('course', 'CourseController@store');
//Route::put('course/{id}', 'CourseController@update');
//Route::delete('course/{id}', 'CourseController@destroy');

//Route::get('page', 'PageController@index');
Route::get('page/{id}', function($id) { return new PageResource(Page::find($id)); });
//Route::post('page', 'PageController@store');