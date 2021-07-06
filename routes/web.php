<?php

use Illuminate\Support\Facades\Auth;
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
    return view('/products/index');
})->middleware('auth');

Route::get('/stock', function () {
    return view('/products/stock');
})->middleware('auth');

Route::get('/categorie', function () {
    return view('/categories/categorie');
})->middleware('auth');

Route::get('/providers', function () {
    return view('/providers/provider');
})->middleware('auth');

Route::get('/adjustment', function () {
    return view('/adjustment/adjustment');
})->middleware('auth');

Route::get('/brand', function () {
    return view('/brand/brand');
})->middleware('auth');

Route::get('/sales', function () {
    return view('/sales/index');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/dashboard/load', 'HomeController@dashboard')->middleware('auth');

Route::get('/api/role/load', 'RoleController@load')->middleware('auth');
Route::get('/api/permission/load', 'PermissionController@load')->middleware('auth');

Route::get('/api/user/load', 'UserController@load')->middleware('auth');
Route::post('/api/user/add', 'UserController@add')->middleware('auth');
Route::post('/api/user/delete', 'UserController@delete')->middleware('auth');
Route::put('/api/user/edit', 'UserController@edit')->middleware('auth');

Route::get('/api/typeid/load', 'TypeIndetificationController@load')->middleware('auth');

Route::get('/api/categorie/index', 'CategorieController@index')->middleware('auth');
Route::get('/api/categorie/load', 'CategorieController@load')->middleware('auth');
Route::post('/api/categorie/add', 'CategorieController@add')->middleware('auth');
Route::put('/api/categorie/edit', 'CategorieController@edit')->middleware('auth');
Route::post('/api/categorie/delete', 'CategorieController@delete')->middleware('auth');

Route::get('/api/unit/load', 'UnitController@load')->middleware('auth');
Route::get('/api/taxe/load', 'TaxeController@load')->middleware('auth');

Route::get('/api/product/load', 'ProductController@load')->middleware('auth');
Route::post('/api/product/add', 'ProductController@add')->middleware('auth');
Route::post('/api/product/edit', 'ProductController@edit')->middleware('auth');
Route::post('/api/product/delete', 'ProductController@delete')->middleware('auth');
Route::get('/api/product/search', 'ProductController@search')->middleware('auth');

Route::get('/api/provider/load', 'SupplierController@load')->middleware('auth');
Route::post('/api/provider/add', 'SupplierController@add')->middleware('auth');
Route::put('/api/provider/edit', 'SupplierController@edit')->middleware('auth');
Route::post('/api/provider/delete', 'SupplierController@delete')->middleware('auth');

Route::get('/api/warehouse/load', 'WarehouseController@load')->middleware('auth');

Route::get('/api/adjustment/load', 'AdjustmentController@load')->middleware('auth');
Route::post('/api/adjustment/add', 'AdjustmentController@add')->middleware('auth');
Route::post('/api/adjustment/edit', 'AdjustmentController@edit')->middleware('auth');
Route::post('/api/adjustment/delete', 'AdjustmentController@delete')->middleware('auth');

Route::get('/api/alertstock/load', 'AlertStockController@load')->middleware('auth');

Route::get('/api/brand/index', 'BrandController@index')->middleware('auth');
Route::get('/api/brand/load', 'BrandController@load')->middleware('auth');
Route::post('/api/brand/add', 'BrandController@add')->middleware('auth');
Route::post('/api/brand/edit', 'BrandController@edit')->middleware('auth');
Route::post('/api/brand/delete', 'BrandController@delete')->middleware('auth');

//NOTIFICATIONS
Route::get('/api/notification/bell', 'NotificationController@bell')->middleware('auth');

Route::get('/api/sale/load', 'SaleController@load')->middleware('auth');
Route::post('/api/sale/add', 'SaleController@add')->middleware('auth');
Route::post('/api/sale/delete', 'SaleController@delete')->middleware('auth');
Route::post('/api/sale/edit', 'SaleController@edit')->middleware('auth');