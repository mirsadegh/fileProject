<?php

Route::middleware('auth')->group(function() {
    Route::resource('/categories', 'CategoryController')->middleware('permission:manage_categories');
});
