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

Route::group(["middleware" => "auth"], function ($router){
    $router->resource("comments", "CommentController");
    $router->patch('comments/{comment}/accept', 'CommentController@accept')->name('comments.accept');
    $router->patch('comments/{comment}/reject', 'CommentController@reject')->name('comments.reject');
});


