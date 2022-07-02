<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

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

Route::get('/', function () {
    return view('index');
});
Route::get('/test', function () {
    Permission::create([
      'name' => 'manage_RolePermission',
    ]);
       auth()->user()->givePermissionTo('manage_RolePermission');
       return auth()->user()->permissions;

});
