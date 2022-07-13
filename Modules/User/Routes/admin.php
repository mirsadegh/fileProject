<?php

Route::group(['middleware' =>['web','auth']],function(){


Route::post('users/{user}/add/role','UserController@addRole')->name('users.addRole');
Route::delete('users/{user}/remove/{role}/role','UserController@removeRole')->name('users.removeRole');
Route::patch('users/{user}/manualVerify',"UserController@manualVerify")->name('users.manualVerify');
Route::post('users/photo',"UserController@updatePhoto")->name('users.photo');
Route::get('users/profile',"UserController@profile")->name('users.profile');
Route::post('users/profile',"UserController@updateProfile");
Route::get('tutors/{username}',"UserController@viewProfile")->name('viewProfile');
Route::resource('users', 'UserController');



});
