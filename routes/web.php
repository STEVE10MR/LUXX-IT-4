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

Route::view('/', 'home')->name('home');

Route::post('login','App\Http\Controllers\SessionsController@store')->name('session.store');
Route::get('logout','App\Http\Controllers\SessionsController@destroy')->name('session.destroy');


Route::get('/user/register','App\Http\Controllers\RegisterController@create')->name('register.create');
Route::post('/user','App\Http\Controllers\RegisterController@store')->name('register.store');


//Auth::routes();


