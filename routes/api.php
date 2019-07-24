<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->group(function(){
// 	});
	
// 	Route::middleware('passport.client.auth')->group(function () {		
// 		Route::get('events', 'Admin\EventsController@index');
// 		Route::post('operating-hours', 'Admin\OperationsController@operatingHours');

// 		Route::middleware('user.authentication')->group(function () {
			
// 			Route::get('cart', 'Api\Cart\CartController@index');
// 			Route::post('purchases', 'Api\ProductsController@purchases');
// 			Route::post('authentication', 'Api\AuthenticationsController@authentication');
// 	});
// });

Route::middleware('auth:api')->group(function(){
});

Route::middleware('passport.client.auth')->group(function () {		
	Route::get('events', 'Admin\EventsController@index');
	Route::post('operating-hours', 'Admin\OperationsController@operatingHours');
	Route::post('guest/add-product', 'Api\Cart\CartController@addToCart');
	Route::post('cart', 'Api\Cart\CartController@getCartProducts');
	Route::get('shop', 'Api\Product\ProductController@index');
	Route::get('product/colours', 'Api\Product\ProductController@colours');
	Route::get('product/sizes', 'Api\Product\ProductController@sizes');

	Route::middleware('user.authentication')->group(function () {
		Route::post('user/add-product', 'Api\Cart\CartController@addToCart');
	});
});