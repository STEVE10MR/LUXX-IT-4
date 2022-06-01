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



Route::get('/','App\Http\Controllers\ClientController@index')->name('Inicio');
Route::get('/cart','App\Http\Controllers\ClientController@open_cart')->name('client.open_carrito');
Route::get('/cart/{product}','App\Http\Controllers\ClientController@add_cart')->name('client.add_cart');


Route::get('/menu','App\Http\Controllers\ProductsController@create_menu')->name('products.create_menu');
Route::get('/products/{product}', 'App\Http\Controllers\ProductsController@show')->name('product.show');

Route::get('logout','App\Http\Controllers\SessionsController@destroy')->name('session.destroy');
Route::post('login','App\Http\Controllers\SessionsController@store')->name('session.store');

Route::get('/user/register','App\Http\Controllers\RegisterController@create')->name('register.create');
Route::post('/user','App\Http\Controllers\RegisterController@store')->name('register.store');

//Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
