<?php


Route::middleware('auth')->group(function() {
    Route::resource('/categories', 'CategoryController');
});
