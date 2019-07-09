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
	// });
	
// 	Route::middleware('passport.client.auth')->group(function () {		
// 		Route::get('events', 'Admin\EventsController@index');
// 		Route::post('operating-hours', 'Admin\OperationsController@operatingHours');

// 		Route::middleware('user.authentication')->group(function () {
			
// 			Route::get('cart', 'Api\Cart\CartController@index');
// 			Route::post('purchases', 'Api\ProductsController@purchases');
// 			Route::post('authentication', 'Api\AuthenticationsController@authentication');
// 	});
// });

Route::post('add-product', 'Api\Cart\CartController@addToCart');
Route::get('cart', 'Api\Cart\CartController@getCartProducts');