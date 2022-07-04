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

Route::view('/modal_test','modal_subject.subject');
Route::get('firebase','App\Http\Controllers\FirebaseController@index');

Route::get('/','App\Http\Controllers\Pedidos\ClientController@index')->name('Inicio');

Route::get('/cart','App\Http\Controllers\Pedidos\ClientController@open_cart')->name('client.open_carrito');
Route::get('/cart/{product}','App\Http\Controllers\Pedidos\ClientController@add_cart')->name('client.add_cart');
Route::post('/cart','App\Http\Controllers\Pedidos\ClientController@add_cart_detail')->name('client.add_cart_detail');
Route::delete('/cart/{id}','App\Http\Controllers\Pedidos\ClientController@cart_destroy')->name('client.cart_destroy');
Route::post('/cart/checkout','App\Http\Controllers\Pedidos\ClientController@create_pedido')->name('client.generate_order');
Route::get('/cart/checkout/{product}/{user_id}/{total}/{token}/{address_id}/{metod}','App\Http\Controllers\Pedidos\ClientController@generar_pedido')->name('client.confirm_order');


Route::get('/menu','App\Http\Controllers\Administracion\ProductsController@create_menu')->name('products.create_menu');
Route::get('/products/{product}', 'App\Http\Controllers\Administracion\ProductsController@show')->name('product.show');
//product -> products

Route::get('/products', 'App\Http\Controllers\Administracion\ProductsController@index')->name('product.index');
Route::get('/products/search', 'App\Http\Controllers\Administracion\ProductsController@search')->name('product.search');
Route::post('/products/register', 'App\Http\Controllers\Administracion\ProductsController@create')->name('product.create');
Route::get('/products/{id}/status', 'App\Http\Controllers\Administracion\ProductsController@update_status')->name('product.status');
Route::post('/products/{id}', 'App\Http\Controllers\Administracion\ProductsController@update')->name('product.update');


Route::get('logout','App\Http\Controllers\Administracion\SessionsController@destroy')->name('session.destroy');
Route::post('login','App\Http\Controllers\Administracion\SessionsController@store')->name('session.store');
Route::get('/register/verify/{token}','App\Http\Controllers\Administracion\SessionsController@verification')->name('session.verification');


Route::get('/user/recovery','App\Http\Controllers\Administracion\ResetPasswordController@create')->name('session.recovery');
Route::post('/user/recovery','App\Http\Controllers\Administracion\ResetPasswordController@store')->name('session.recovery_verification');
Route::get('/user/password/{token}','App\Http\Controllers\Administracion\ResetPasswordController@edit')->name('session.edit_password');
Route::post('/user/password/','App\Http\Controllers\Administracion\ResetPasswordController@update')->name('session.update_password');


Route::get('/user/register','App\Http\Controllers\Administracion\RegisterController@create')->name('register.create');
Route::post('/user','App\Http\Controllers\Administracion\RegisterController@store')->name('register.store_client');

Route::post('/panel/user','App\Http\Controllers\Administracion\UserController@store')->name('register.store');

Route::get('/statistics','App\Http\Controllers\Ventas\OrdersController@statistics')->name('statistics');
Route::get('/panel','App\Http\Controllers\Ventas\OrdersController@index')->name('order.panel');

Route::get('/users','App\Http\Controllers\Administracion\UserController@index')->name('user.index');
Route::post('/users/register','App\Http\Controllers\Administracion\UserController@store')->name('user.create');
Route::get('/users/{id}/status','App\Http\Controllers\Administracion\UserController@update_status')->name('user.status');
Route::post('/users/reset','App\Http\Controllers\Administracion\UserController@reset_password')->name('user.reset_password');

Route::get('/categories','App\Http\Controllers\Administracion\CategoriesController@index')->name('categories.index');
Route::post('/categories/register','App\Http\Controllers\Administracion\CategoriesController@store')->name('categories.store');
Route::post('/categories/{id}/edit','App\Http\Controllers\Administracion\CategoriesController@update')->name('categories.update');
Route::delete('/categories/{id}','App\Http\Controllers\Administracion\CategoriesController@destroy')->name('categories.destroy');

Route::get('/account/profile','App\Http\Controllers\Administracion\UserController@edit_profile')->name('user.profile');
Route::post('/account/profile/edit','App\Http\Controllers\Administracion\UserController@update_profile')->name('user.update_profile');

Route::get('/account/address/register','App\Http\Controllers\Pedidos\AddressController@create')->name('user.address');
Route::post('/account/address','App\Http\Controllers\Pedidos\AddressController@store')->name('address.store');
Route::delete('/account/address/{id}','App\Http\Controllers\Pedidos\AddressController@destroy')->name('address.destroy');

Route::get('/account/management','App\Http\Controllers\Administracion\UserController@management')->name('user.management');
Route::get('/account/orders','App\Http\Controllers\Ventas\OrdersController@my_orders')->name('user.orders');

Route::get('/orders','App\Http\Controllers\Ventas\OrdersController@deliver_orders')->name('delivery.orders');
Route::get('/account/deliveries','App\Http\Controllers\Ventas\OrdersController@my_deliveries')->name('delivery.deliveries');

//

//proteger
Route::post('/orders/map/checkout','App\Http\Controllers\Pedidos\FirebaseController@update')->name('firebase.update');
Route::post('/orders/map','App\Http\Controllers\Pedidos\FirebaseController@create')->name('firebase.create');
Route::get('/panel/map','App\Http\Controllers\Pedidos\FirebaseController@create_map')->name('firebase.create_map');
Route::get('/panel/map/load','App\Http\Controllers\Pedidos\FirebaseController@load_map')->name('firebase.load_map');

Route::post('/orders/map/load','App\Http\Controllers\Pedidos\FirebaseController@load')->name('firebase.load');
Route::get('/orders/map/load/user','App\Http\Controllers\Pedidos\FirebaseController@show_delivery')->name('firebase.return_delivery');


//Auth::routes();
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
