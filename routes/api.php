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


Route::post('register', 'UserController@register');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['prefix' => 'wishlist', 'middleware' => 'jwt.auth'], function () {
	Route::get('/', 'WishlistController@index');
	Route::get('/{id}', 'WishlistController@show');
	Route::post('/', 'WishlistController@store');
	Route::post('/view', 'WishlistController@view');
	Route::post('/buy', 'WishlistController@buyItem');
	Route::post('/item', 'WishlistController@getItem');
	Route::post('/item/update', 'WishlistController@updateItem');
	Route::post('/delete/{wishlist}', 'WishlistController@delete');
});