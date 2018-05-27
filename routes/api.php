<?php
use Illuminate\Http\Request;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;

use App\Course;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;

use App\Page;
use App\Http\Resources\PageResource;

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

Route::get('categories', function() { return new CategoryResourceCollection(Category::paginate(5)); });
Route::get('categories/{id}', function($id) { return new CategoryResource(Category::find($id)); });

Route::get('courses', function() { return new CourseResourceCollection(Course::paginate(5)); });
Route::get('courses/{id}', function($id) { return new CourseResource(Course::find($id)); });
//Route::post('course', 'CourseController@store');
//Route::put('course/{id}', 'CourseController@update');
//Route::delete('course/{id}', 'CourseController@destroy');

//Route::get('page', 'PageController@index');
Route::get('pages/{id}', function($id) { return new PageResource(Page::find($id)); });
//Route::post('page', 'PageController@store');