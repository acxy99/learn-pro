<?php
use Illuminate\Http\Request;

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
    Route::get('/categories/{id}', 'CategoryController@apiShow');
    Route::get('/categories/{id}/courses', 'CategoryController@apiCourses');
    Route::apiResource('categories', 'CategoryController')->only(['store', 'update']);

    Route::get('/courses', 'CourseController@apiIndex');
    Route::get('/courses/{id}', 'CourseController@apiShow');
    Route::apiResource('courses', 'CourseController')->only(['store', 'update']);

    Route::get('/courses/topic/{topic_id}/pages', 'PageController@apiIndex');
    Route::apiResource('pages', 'PageController')->only(['store', 'update']);

    Route::get('/courses/topic/{topic_id}/files', 'FileController@apiIndex');
    Route::apiResource('files', 'FileController')->only(['store', 'update']);

    Route::get('/courses/{course_id}/topic','TopicController@apiIndex');
    Route::apiResource('topic', 'TopicController')->only(['store','update']);


    Route::get('/courses/topic/{topic_id}/pla','PlaController@apiIndex');
    Route::apiResource('pla', 'PlaController')->only(['store','update']);

    Route::get('/courses/{course_id}/leap','LeapController@apiIndex');
    Route::apiResource('leap', 'LeapController')->only(['store','update']);
});

/*
    Frontend
*/
Route::namespace('Frontend')->group(function() {
    Route::resource('profiles', 'ProfileController')->only(['update']);

    Route::get('/categories', 'CategoryController@apiIndex');
    Route::get('/categories/{category_id}/courses', 'CategoryController@apiCourses');
    Route::get('/categories/popular', 'CategoryController@apiPopular');

    Route::get('/courses', 'CourseController@apiIndex');
    Route::get('/courses/{course_id}/pages', 'CourseController@apiPages');
    Route::get('/courses/{course_id}/files', 'CourseController@apiFiles');
    Route::get('/courses/new', 'CourseController@apiNew');
});