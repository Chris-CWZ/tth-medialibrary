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
		Route::post('events/date', 'Api\EventsController@getEventByDate');
		Route::post('event/bookmark', 'Api\BookmarksController@eventBookmark');
		Route::post('bookmarks-events', 'Api\BookmarksController@getBookmarkedEvents');
		Route::post('operating-hours', 'Api\OperationsController@operatingHours');
		Route::post('event/next', 'Api\EventsController@nextEvent');
		Route::post('event/previous', 'Api\EventsController@previousEvent');

		// Products
		Route::post('product/add', 'Api\CartController@addToCart');
		Route::post('product/remove', 'Api\CartController@removeFromCart');
		Route::post('purchases', 'Api\PurchasesController@purchases');
		Route::post('shop', 'Api\ProductsController@retrieveProductsList');
		Route::get('product/colours', 'Api\ProductsController@colours');
		Route::get('product/sizes', 'Api\ProductsController@sizes');
		Route::post('bookmarks-products', 'Api\BookmarksController@getBookmarkedProducts');
		Route::post('product/bookmark', 'Api\BookmarksController@productBookmark');

		// Cart
		Route::get('cart', 'Api\CartController@getCartProducts');
		Route::post('cart/change', 'Api\CartController@changeCartProduct');

		// Promotions
		Route::post('promotion/apply', 'Api\PromotionsController@applyPromoCode');
		Route::post('promotion/remove', 'Api\PromotionsController@removePromoCode');

		// Payment
		Route::post('payment/process', 'PaymentsController@process');

		// Orders
		Route::post('order/create', 'Api\OrdersController@createOrder');
		Route::post('user/orders', 'Api\OrdersController@getOrders');
		Route::get('user/addresses', 'Api\OrdersController@getAddresses');
		Route::get('user/addresses/create', 'Api\OrdersController@createAddress');
	});

	Route::get('credentials', 'Api\AuthController@credentials');
