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
Route::middleware('auth')->group(function () {
    Route::resource("tickets", "TicketController");
    Route::post("tickets/{ticket}/reply", "TicketController@reply")->name("tickets.reply");
    Route::get("tickets/{ticket}/close", "TicketController@close")->name("tickets.close");

});
