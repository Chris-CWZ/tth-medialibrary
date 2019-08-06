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
<<<<<<< HEAD
		Route::post('events/date', 'Api\EventsController@getEventByDate');
		Route::post('event/bookmark', 'Api\BookmarksController@eventBookmark');
		Route::post('bookmarks-events', 'Api\BookmarksController@getBookmarkedEvents');
		Route::post('operating-hours', 'Api\OperationsController@operatingHours');

		// Products
		Route::post('product/add', 'Api\CartController@addToCart');
		Route::post('product/remove', 'Api\CartController@removeFromCart');
		Route::post('purchases', 'Api\PurchasesController@purchases');
		Route::get('cart', 'Api\CartController@getCartProducts');
		Route::post('shop', 'Api\ProductsController@retrieveProductsList');
		Route::get('product/colours', 'Api\ProductsController@colours');
		Route::get('product/sizes', 'Api\ProductsController@sizes');
		Route::post('bookmarks-products', 'Api\BookmarksController@getBookmarkedProducts');
		Route::post('product/bookmark', 'Api\BookmarksController@productBookmark');

		// Payment
		Route::post('payment/process', 'PaymentsController@process');

		// Orders
		Route::post('order/create', 'Api\OrdersController@createOrder');
		Route::post('user/orders', 'Api\OrdersController@getOrders');
		Route::get('user/addresses', 'Api\OrdersController@getAddresses');
		Route::get('user/addresses/create', 'Api\OrdersController@createAddress');
	});

	Route::get('credentials', 'Api\AuthController@credentials');
=======
		Route::post('events/date', 'Api\Events\EventsController@getEventByDate');
		Route::post('event/bookmark', 'Api\Bookmarks\BookmarksController@eventBookmark');
		Route::post('bookmarks-events', 'Api\Bookmarks\BookmarksController@getBookmarkedEvents');
		Route::post('operating-hours', 'Admin\OperationsController@operatingHours');

		// Products
		Route::post('product/add', 'Api\Cart\CartController@addToCart');
		Route::post('product/remove', 'Api\Cart\CartController@removeFromCart');
		Route::post('purchases', 'Api\PurchasesController@purchases');
		Route::get('cart', 'Api\Cart\CartController@getCartProducts');
		Route::post('shop', 'Api\Products\ProductsController@retrieveProductsList');
		Route::get('product/colours', 'Api\Products\ProductsController@colours');
		Route::get('product/sizes', 'Api\Products\ProductsController@sizes');
		Route::post('bookmarks-products', 'Api\Bookmarks\BookmarksController@getBookmarkedProducts');
		Route::post('product/bookmark', 'Api\Bookmarks\BookmarksController@productBookmark');

		// Payment
		Route::post('payment/process', 'PaymentsController@process');

		// Orders
		Route::post('order/create', 'Api\Orders\OrdersController@createOrder');
		Route::post('user/orders', 'Api\Orders\OrdersController@getOrders');
	});
>>>>>>> cc50751a7fcfcfd07cd9287642129a2ae52d67bc
