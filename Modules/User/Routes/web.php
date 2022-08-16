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

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Frontend\Auth\LoginRegisterController;



    Route::group(['middleware' => 'guest'],function (){
        Route::get('login-register',[LoginRegisterController::class,'loginRegisterForm'])->name('auth.login-register-form');
        Route::middleware('throttle:customer-login-register-limiter')->post('login-register',[LoginRegisterController::class,'loginRegister'])->name('auth.login-register');

        Route::get('login-confirm/{token}',[LoginRegisterController::class,'loginConfirmForm'])->name('auth.login-confirm-form');
        Route::middleware('throttle:customer-login-confirm-limiter')->post('login-confirm/{token}',[LoginRegisterController::class,'loginConfirm'])->name('auth.login-confirm');
        Route::middleware('throttle:customer-login-resend-otp-limiter')->get('login-resend-otp/{token}',[LoginRegisterController::class,'loginResendOtp'])->name('auth.login-resend-otp');
    });


    Route::get('users/profile',"UserController@profile")->name('users.profile');
    Route::post('users/profile',"UserController@updateProfile");
    Route::get('users/{user}/info', ["uses" => "UserController@info", "as" => 'users.info']);
    Route::any('/logout',[LoginRegisterController::class,'logout'])->name('logout');



