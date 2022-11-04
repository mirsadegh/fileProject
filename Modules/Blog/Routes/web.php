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
    Route::get('/{blog}/edit', 'BlogController@edit')->name('blogs.admin.edit');
    Route::patch('/update/{blog}', 'BlogController@update')->name('blogs.admin.update');
    Route::delete('/delete/{blog}', 'BlogController@destroy')->name('blogs.admin.destroy');
});
