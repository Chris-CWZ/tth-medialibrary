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
	
	Route::middleware('passport.client.auth')->group(function () {
		
		// Events
		Route::get('events', 'Admin\EventsController@index');
		Route::post('operating-hours', 'Admin\OperationsController@operatingHours');

		// Products
		Route::post('purchases', 'Api\PurchasesController@purchases');
		Route::get('cart', 'Api\Cart\CartController@getCartProducts');
		Route::get('shop', 'Api\Products\ProductsController@index');
		Route::post('product/add', 'Api\Cart\CartController@addToCart');
		Route::post('product/remove', 'Api\Cart\CartController@removeFromCart');
		Route::get('product/colours', 'Api\Products\ProductsController@colours');
		Route::get('product/sizes', 'Api\Products\ProductsController@sizes');
		Route::post('bookmarks-products', 'Api\Bookmarks\BookmarksController@getBookmarkedProducts');
		Route::post('product/bookmark', 'Api\Bookmarks\BookmarksController@productBookmark');
	});

	Route::post('payment/process', 'PaymentsController@process');
