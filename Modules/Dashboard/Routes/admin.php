<?php


Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');
});
