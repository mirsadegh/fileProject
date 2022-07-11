<?php

Route::resource('users', 'UserController');

Route::post('users/{user}/add/role','UserController@addRole')->name('users.addRole');
Route::delete('users/{user}/remove/{role}/role','UserController@removeRole')->name('users.removeRole');
Route::patch('users/{user}/manualVerify',"UserController@manualVerify")->name('users.manualVerify');

