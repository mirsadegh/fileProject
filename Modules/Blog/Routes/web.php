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

Route::prefix('blogs')->group(function() {
    Route::get('/', 'BlogController@index')->name('blogs.admin.index');
    Route::get('/create', 'BlogController@create')->name('blogs.admin.create');
    Route::post('/store', 'BlogController@store')->name('blogs.admin.store');
});
