<?php

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


//Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware('register.access')->group(function () {
        Route::get('register', "Admin\AuthController@viewRegister")->name('admin.register.show');
        Route::post('register', "Admin\AuthController@register")->name('admin.register');
    });

    Route::middleware('admin.login')->group(function () {
        Route::get('login', 'Admin\AuthController@viewLogin')->name('admin.login.show');
        Route::post('login', 'Admin\AuthController@login')->name('admin.login');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::name('admin.')->group(function () {
            Route::resource('users', 'Admin\UsersController', ['only' => ['index', 'edit', 'update', 'destroy']]);
            Route::resource('events', 'Admin\EventsController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
            Route::get('/calendar', 'Admin\OperationsController@calendar')->name('calendar');
            Route::resource('orders', 'Admin\OrdersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
            Route::resource('articles', 'Admin\ArticlesController', ['only' => ['index', 'edit', 'update', 'destroy']]);
            Route::resource('directories', 'Admin\DirectoriesController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
        });

        Route::get('/', 'Admin\DashboardController@dashboard');
        Route::get('dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
        Route::get('logout', 'Admin\AuthController@logout')->name('admin.logout');

        //Settings
        Route::get('settings', "Admin\AccountSettingsController@viewAccount")->name("admin.account.show");
        Route::post('settings', "Admin\AccountSettingsController@updateAccount")->name("admin.account.update");
        Route::put('settings/password', "Admin\AccountSettingsController@updatePassword")->name("admin.password.change");
    });
});

Route::get('/', 'Client\HomeController@home')->name('root');
Route::get('/home', 'Client\HomeController@home')->name('home');
