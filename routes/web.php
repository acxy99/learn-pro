<?php

use App\Course;
use App\Category;
use App\User;

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

/*
    Authentication (login, logout, user registration, password reset)
*/
// Auth::routes();

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () { return view('home'); });

// Route::get('/home', 'HomeController@index')->name('home');

/*
    Admin
*/
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/', function() {
        $user = Auth::user();

        if ($user->isAn('admin')) {
            $courses_count = Course::count();
            $categories_count = Category::count();
            $users_count = User::count();
        } else {
            $courses_count = $user->teachingCourses()->count();
            $categories_count = 0;
            $users_count = 0;
        }

        return view('admin.dashboard', [
            'courses_count' => $courses_count,
            'categories_count' => $categories_count,
            'users_count' => $users_count,
        ]);
    })->middleware('can:view-dashboard')->name('dashboard');

    Route::resource('/users', 'UserController');

    Route::resource('/categories', 'CategoryController');

    Route::resource('/courses', 'CourseController');

    Route::get('/courses/{course_slug}/pages', 'PageController@index');
    Route::get('/courses/{course_slug}/pages/create', 'PageController@create');
    Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');
    Route::get('/courses/{course_slug}/pages/{page_slug}/edit', 'PageController@edit');
    Route::post('/courses/{course_slug}/pages/uploadImage', 'PageController@uploadImage');
    Route::resource('/pages', 'PageController')->only(['destroy']);

    Route::get('/courses/{course_slug}/files', 'FileController@index');
    Route::get('/courses/{course_slug}/files/create', 'FileController@create');
    Route::get('/courses/{course_slug}/files/{file_id}/edit', 'FileController@edit');
    Route::resource('/files', 'FileController')->only(['destroy']);
});

/*
    Frontend
*/
Route::namespace('Frontend')->name('frontend.')->group(function() {
    Route::resource('/categories', 'CategoryController')->only(['index', 'show']);

    Route::resource('/courses', 'CourseController')->only(['index', 'show']);
    
    Route::get('/courses/{course_slug}/pages/{page_slug}', 'PageController@show');

    Route::resource('/profiles', 'ProfileController')->only(['show', 'edit']);
});