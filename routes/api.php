<?php
use Illuminate\Http\Request;

use App\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;

use App\Course;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;

use App\Page;
use App\Http\Resources\PageResource;
use App\Http\Resources\PageResourceCollection;

use App\File;
use App\Http\Resources\FileResourceCollection;

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

/*
    Admin
*/
Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/users', 'UserController@apiIndex');
    Route::get('/users/{id}', 'UserController@apiShow');
    Route::apiResource('users', 'UserController')->only(['store', 'update']);

    Route::get('/categories', 'CategoryController@apiIndex');
    Route::get('/categories/{id}/courses', function($id) {
        $category = Category::findOrFail($id);
        return new CourseResourceCollection (
            $category->courses()->paginate(5)
        );
    });
    Route::apiResource('categories', 'CategoryController')->only(['store', 'update']);

    Route::get('/courses', 'CourseController@apiIndex');
    Route::get('/courses/{id}', 'CourseController@apiShow');
    Route::apiResource('courses', 'CourseController')->only(['store', 'update']);

    Route::get('/courses/{course_id}/pages', 'PageController@apiIndex');
    Route::apiResource('pages', 'PageController')->only(['store', 'update']);

    Route::get('/courses/{course_id}/files', 'FileController@apiIndex');
    Route::apiResource('files', 'FileController')->only(['store', 'update']);
});

/*
    Frontend
*/
Route::namespace('Frontend')->group(function() {
    Route::resource('profiles', 'ProfileController')->only(['update', 'destroy']);

    Route::get('/categories', 'CategoryController@apiIndex');
    Route::get('/categories/{category_id}/courses', function($category_id) {
        $category = Category::findOrFail($category_id);
        return new CourseResourceCollection (
            $category->courses()->paginate(9)
        );
    });

    Route::get('/courses', 'CourseController@apiIndex');
    
    Route::get('/courses/{course_id}/pages', function($course_id) {
        $course = Course::find($course_id);
        return new PageResourceCollection(
            Page::where([
                'course_id' => $course->id,
                'parent_id' => null,
            ])->paginate(10)
        ); 
    });
    
    Route::get('/courses/{course_id}/files', function($course_id) {
        $course = Course::find($course_id);
        return new FileResourceCollection(
            File::where([
                'course_id' => $course->id,
            ])->paginate(10)
        ); 
    });
});