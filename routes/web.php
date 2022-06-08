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
/*
DB::listen(function($query)
{
    echo "<pre>{$query->sql}</pre>";
});
*/

Route::get('/','App\Http\Controllers\ClientController@index')->name('Inicio');

Route::get('/cart','App\Http\Controllers\ClientController@open_cart')->name('client.open_carrito');
Route::get('/cart/{product}','App\Http\Controllers\ClientController@add_cart')->name('client.add_cart');
Route::post('/cart','App\Http\Controllers\ClientController@add_cart_detail')->name('client.add_cart_detail');
Route::delete('/cart/{id}','App\Http\Controllers\ClientController@cart_destroy')->name('client.cart_destroy');

Route::get('/menu','App\Http\Controllers\ProductsController@create_menu')->name('products.create_menu');
Route::get('/products/{product}', 'App\Http\Controllers\ProductsController@show')->name('product.show');
Route::get('/product', 'App\Http\Controllers\ProductsController@index')->name('product.index');
Route::get('/product/search', 'App\Http\Controllers\ProductsController@search')->name('product.search');
Route::post('/product/register', 'App\Http\Controllers\ProductsController@create')->name('product.create');
Route::get('/product/{id}/status', 'App\Http\Controllers\ProductsController@update_status')->name('product.status');

Route::get('logout','App\Http\Controllers\SessionsController@destroy')->name('session.destroy');
Route::post('login','App\Http\Controllers\SessionsController@store')->name('session.store');

Route::get('/account/profile','App\Http\Controllers\ClientController@edit_profile')->name('user.profile');
Route::post('/account/profile/edit','App\Http\Controllers\ClientController@update_profile')->name('user.update_profile');

Route::get('/user/register','App\Http\Controllers\RegisterController@create')->name('register.create');
Route::post('/user','App\Http\Controllers\RegisterController@store')->name('register.store');

Route::get('/panel','App\Http\Controllers\UserController@index')->name('admin.panel');

//Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
