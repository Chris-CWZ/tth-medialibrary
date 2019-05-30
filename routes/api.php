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
	
	Route::middleware('passport.client.auth')->group(function () {		
		Route::get('events', 'Admin\EventsController@index');

		Route::middleware('user.authentication')->group(function () {
			Route::post('authentication', 'Api\AuthenticationsController@authentication');
	});
});