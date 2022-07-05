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

Route::middleware('auth')->group(function() {
    Route::resource('/courses', 'CourseController');
    Route::patch('courses/{course}/accept','CourseController@accept')->name('courses.accept');
    Route::patch('courses/{course}/reject','CourseController@reject')->name('courses.reject');
    Route::patch('courses/{course}/lock','CourseController@lock')->name('courses.lock');
    Route::get('courses/{course}/details','CourseController@details')->name('courses.details');
    Route::post('courses/{course}/buy','CourseController@buy')->name('courses.buy');
    Route::get('courses/{course}/download-links','CourseController@downloadLinks')->name('courses.downloadLinks');
});
