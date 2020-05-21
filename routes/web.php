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
    return view('welcome');
});

/* --- Route User ---  */
Route::get('home', 'HomeController@index')->name('home');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('refreshtoken', 'UserController@refreshToken');
Route::get('unauthorized', 'UserController@unauthorized');


Auth::routes();
Route::get('logout', 'UserController@logout');
Route::get('details', 'UserController@details');
Route::post('upload/profile', 'UserController@upload');
Route::post('upload/ktp', 'UserController@uploadKtp');
Route::post('password', 'UserController@updatePassword');
Route::post('details', 'UserController@updateDetails');


/* --- Route Warung ---  */
Route::get('shop', 'ShopController@show');
Route::post('shop', 'ShopController@create');
Route::post('shop/open', 'ShopController@open');
Route::post('update/shop', 'ShopController@updateDetails');
Route::post('upload/shop', 'ShopController@uploadImage');

/* --- Route Product ---  */
Route::get('products', 'ProductController@index');
Route::post('products', 'ProductController@create');
Route::get('products/all', 'ProductController@all');
Route::post('products/{id?}/publish', 'ProductController@publish');
Route::get('products/{id?}', 'ProductController@show');
Route::post('products/{id?}', 'ProductController@update');
Route::delete('products/{id?}', 'ProductController@destroy');
Route::post('upload/products1', 'ProductController@upload1');
Route::post('upload/products2', 'ProductController@upload2');
Route::post('upload/products3', 'ProductController@upload3');






