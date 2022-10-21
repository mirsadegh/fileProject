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

Route::prefix('front')->group(function() {
    Route::get('/', 'FrontController@index');
    Route::get('all-course','FrontController@allCourse')->name('allCourse');
    Route::get('/c-{slug}','FrontController@singleCourse')->name('singleCourse');
    Route::get('/tutors/{id}', 'FrontController@singleTutor')->name('singleTutor');
});
