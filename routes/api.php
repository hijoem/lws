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
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('refreshtoken', 'UserController@refreshToken');
Route::get('/unauthorized', 'UserController@unauthorized');
Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::post('logout', 'UserController@logout');
    Route::post('details', 'UserController@details');
    Route::post('upload/profile', 'UserController@upload');
    Route::post('update/password', 'UserController@updatePassword');
    Route::post('update/details', 'UserController@updateDetails');
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* --- Route Products ---  */
Route::get('/products', 'ProductController@index');
Route::get('/products/all', 'ProductController@all');
Route::post('/products', 'ProductController@store');
Route::get('/products/{id?}', 'ProductController@show');
Route::post('/products/{id?}', 'ProductController@update');
Route::delete('/products/{id?}', 'ProductController@destroy');

/* --- Route Post ---  */
Route::get('/posts', 'PostsController@index');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{id?}', 'PostsController@show');
Route::post('/posts/{id?}', 'PostsController@update');
Route::delete('/posts/{id?}', 'PostsController@destroy');
