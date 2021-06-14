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
})->middleware('auth');

Route::get('/products', function () {
    return view('products.index');
});

Route::get('/categorie', function () {
    return view('/categories/categorie');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/role/load', 'RoleController@load')->middleware('auth');
Route::get('/api/permission/load', 'PermissionController@load')->middleware('auth');

Route::get('/api/user/load', 'UserController@load')->middleware('auth');
Route::post('/api/user/add', 'UserController@add')->middleware('auth');
Route::post('/api/user/delete', 'UserController@delete')->middleware('auth');
Route::put('/api/user/edit', 'UserController@edit')->middleware('auth');

Route::get('/api/typeid/load', 'TypeIndetificationController@load')->middleware('auth');

Route::get('/api/categorie/load', 'CategorieController@load')->middleware('auth');
Route::post('/api/categorie/add', 'CategorieController@add')->middleware('auth');
Route::post('/api/categorie/edit', 'CategorieController@edit')->middleware('auth');
Route::post('/api/categorie/delete', 'CategorieController@delete')->middleware('auth');