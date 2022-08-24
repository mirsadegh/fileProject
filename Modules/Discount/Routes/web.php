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


Route::get('/discounts','DiscountController@index')->name('discounts.index');
Route::post("/discounts", "DiscountController@store")->name("discounts.store");
Route::delete("/discounts/{discount}", "DiscountController@destroy")->name("discounts.destroy");
Route::get("/discounts/{discount}/edit", "DiscountController@edit")->name("discounts.edit");
Route::patch("/discounts/{discount}", "DiscountController@update")->name("discounts.update");
Route::get("/discounts/{code}/{course}/check", "DiscountController@check")->name("discounts.check")->middleware("throttle:6,1");
