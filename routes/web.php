<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Route::get('/user', function () {
    return view('/users/user');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/role/load', 'RoleController@load')->middleware('auth');
Route::get('/api/permission/load', 'PermissionController@load')->middleware('auth');

Route::get('/api/user/load', 'UserController@load')->middleware('auth');
Route::post('/api/user/add', 'UserController@add')->middleware('auth');
Route::post('/api/user/delete', 'UserController@delete')->middleware('auth');
Route::put('/api/user/edit', 'UserController@edit')->middleware('auth');

Route::get('/api/typeid/load', 'TypeIndetificationController@load')->middleware('auth');