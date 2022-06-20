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
Route::post('/cart/checkout','App\Http\Controllers\ClientController@create_pedido')->name('client.generate_order');
Route::get('/cart/checkout/{product}/{user_id}/{total}/{token}/{address_id}/{metod}','App\Http\Controllers\ClientController@generar_pedido')->name('client.confirm_order');

Route::get('/menu','App\Http\Controllers\ProductsController@create_menu')->name('products.create_menu');
Route::get('/products/{product}', 'App\Http\Controllers\ProductsController@show')->name('product.show');
//product -> products
Route::get('/products', 'App\Http\Controllers\ProductsController@index')->name('product.index');
Route::get('/products/search', 'App\Http\Controllers\ProductsController@search')->name('product.search');
Route::post('/products/register', 'App\Http\Controllers\ProductsController@create')->name('product.create');
Route::get('/products/{id}/status', 'App\Http\Controllers\ProductsController@update_status')->name('product.status');
Route::post('/products/{id}', 'App\Http\Controllers\ProductsController@update')->name('product.update');

Route::get('logout','App\Http\Controllers\SessionsController@destroy')->name('session.destroy');
Route::post('login','App\Http\Controllers\SessionsController@store')->name('session.store');

Route::get('/user/register','App\Http\Controllers\RegisterController@create')->name('register.create');
Route::post('/user','App\Http\Controllers\RegisterController@store')->name('register.store');

Route::post('/user','App\Http\Controllers\UserController@store')->name('register.store');

Route::get('/panel','App\Http\Controllers\OrdersController@index')->name('order.panel');

Route::get('/users','App\Http\Controllers\UserController@index')->name('user.index');
Route::post('/users/register','App\Http\Controllers\UserController@store')->name('user.create');
Route::get('/users/{id}/status','App\Http\Controllers\UserController@update_status')->name('user.status');
Route::post('/users/reset','App\Http\Controllers\UserController@reset_password')->name('user.reset_password');

Route::get('/categories','App\Http\Controllers\CategoriesController@index')->name('categories.index');
Route::post('/categories/register','App\Http\Controllers\CategoriesController@store')->name('categories.store');
Route::post('/categories/{id}/edit','App\Http\Controllers\CategoriesController@update')->name('categories.update');
Route::delete('/categories/{id}','App\Http\Controllers\CategoriesController@destroy')->name('categories.destroy');

Route::get('/account/profile','App\Http\Controllers\UserController@edit_profile')->name('user.profile');
Route::post('/account/profile/edit','App\Http\Controllers\UserController@update_profile')->name('user.update_profile');

Route::get('/account/address/register','App\Http\Controllers\AddressController@create')->name('user.address');
Route::post('/account/address','App\Http\Controllers\AddressController@store')->name('address.store');
Route::delete('/account/address/{id}','App\Http\Controllers\AddressController@destroy')->name('address.destroy');

Route::get('/account/management','App\Http\Controllers\UserController@management')->name('user.management');

Route::get('/account/orders','App\Http\Controllers\OrdersController@my_orders')->name('user.orders');

//Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
