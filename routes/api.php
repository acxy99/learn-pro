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
use App\Http\Resources\PageResourceCollection;

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

// Route::get('categories', function() { return new CategoryResourceCollection(Category::paginate(5)); });
// Route::get('categories/{id}', function($id) { return new CategoryResource(Category::find($id)); });

Route::get('/courses', function() { return new CourseResourceCollection(Course::paginate(9)); });
Route::post('/courses', 'CourseController@store');
Route::put('/courses/{id}', 'CourseController@update');
Route::delete('courses/{id}', 'CourseController@destroy');

Route::get('/courses/{course_id}/pages', function($course_id) {
    $course = Course::find($course_id);
    return new PageResourceCollection(
        Page::where([
            'course_id' => $course->id,
            'parent_id' => null,
        ])->paginate(10)
    ); 
});
Route::post('/pages', 'PageController@store');
Route::put('/pages/{id}', 'PageController@update');
Route::delete('/pages/{id}', 'PageController@destroy');

Route::post('/files', 'FileController@store');