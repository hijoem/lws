<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* --- Route User ---  */
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('refreshtoken', 'API\UserController@refreshToken');
Route::get('unauthorized', 'API\UserController@unauthorized');
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::post('logout', 'API\UserController@logout');
    Route::get('details', 'API\UserController@details');
    Route::post('upload/profile', 'API\UserController@upload');
    Route::post('upload/ktp', 'API\UserController@uploadKtp');
    Route::post('password', 'API\UserController@updatePassword');
    Route::post('details', 'API\UserController@updateDetails');
});

/* --- Route Shop / Warung ---  */
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::get('shop', 'API\ShopController@show');
    Route::post('shop', 'API\ShopController@create');
    Route::post('shop/open', 'API\ShopController@open');
    Route::post('shop/{id?}/activate', 'API\ShopController@activate');
    Route::post('update/shop', 'API\ShopController@updateDetails');
    Route::post('upload/shop', 'API\ShopController@uploadImage');
});

/* --- Route Product ---  */
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::get('products', 'API\ProductController@index');
    Route::post('products', 'API\ProductController@create');
    Route::get('products/all', 'API\ProductController@all');
    Route::post('products/{id?}/publish', 'API\ProductController@publish');
    Route::get('products/{id?}', 'API\ProductController@show');
    Route::post('products/{id?}', 'API\ProductController@update');
    Route::delete('products/{id?}', 'API\ProductController@destroy');
    Route::post('upload/products1', 'API\ProductController@upload1');
    Route::post('upload/products2', 'API\ProductController@upload2');
    Route::post('upload/products3', 'API\ProductController@upload3');
});

/* --- Route RT ---  */
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::get('rt/all', 'API\RTController@all');
    Route::get('rt', 'API\RTController@show');
    Route::post('rt', 'API\RTController@create');
    Route::get('rt/{id?}', 'API\RTController@view');
    Route::post('rt/{id?}', 'API\RTController@join');
    Route::post('rt/{id?}/activate', 'API\RTController@activate');
    Route::post('update/rt', 'API\RTController@updateDetails');
    Route::post('upload/rt', 'API\RTController@uploadImage');
    Route::post('upload/sk', 'API\RTController@uploadSk');
});

/* --- Route Community ---  */
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::get('community/all', 'API\RTController@all');
    Route::get('community', 'API\RTController@show');
    Route::post('community', 'API\RTController@create');
    Route::get('community/{id?}', 'API\RTController@view');
    Route::post('community/{id?}', 'API\RTController@join');
    Route::post('community/{id?}/activate', 'API\RTController@activate');
    Route::post('update/community', 'API\RTController@updateDetails');
    Route::post('upload/community', 'API\RTController@uploadImage');
});

/* --- Route Info ---  */
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::get('info', 'API\InfoController@index');
    Route::post('info', 'API\InfoController@create');
    Route::get('info/all', 'API\InfoController@all');
    Route::post('info/{id?}/publish', 'API\InfoController@publish');
    Route::get('info/{id?}', 'API\InfoController@show');
    Route::post('info/{id?}', 'API\InfoController@update');
    Route::delete('info/{id?}', 'API\InfoController@destroy');
    Route::post('upload/infofile', 'API\InfoController@uploadFile');
    Route::post('upload/info1', 'API\InfoController@uploadImage1');
    Route::post('upload/info2', 'API\InfoController@uploadImage1');
    Route::post('upload/info3', 'API\InfoController@uploadImage1');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});








/* --- Route Post --- tidak terpakai ---  */
Route::get('/posts', 'API\PostsController@index');
Route::post('/posts', 'API\PostsController@store');
Route::get('/posts/{id?}', 'API\PostsController@show');
Route::post('/posts/{id?}', 'API\PostsController@update');
Route::delete('/posts/{id?}', 'API\PostsController@destroy');
