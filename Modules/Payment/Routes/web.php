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


    Route::get('/payments', 'PaymentController@index')->name('payments.index');
    Route::any("payments/callback", "PaymentController@callback")->name("payments.callback");
    Route::get('purchases', [
        "uses" => "PaymentController@purchases",
        "as" => ("purchases.index")
    ]);
