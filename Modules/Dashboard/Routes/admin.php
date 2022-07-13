<?php


Route::prefix('dashboard')->middleware(['auth','verified'])->group(function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');
});
