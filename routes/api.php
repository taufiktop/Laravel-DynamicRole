<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::post('/login', 'Auth\AuthController@login')->name('login'); //login for all
    Route::post('/register', 'Auth\AuthController@register')->name('register'); //register for client
    Route::post('/send-otp', 'Otp\OtpController@sendOtp')->name('send-otp'); 
    Route::post('/verify-otp', 'Otp\OtpController@verifyOtp')->name('verify-otp'); 
    Route::get('/refresh', 'Auth\AuthController@refresh'); //refresh token

    Route::middleware('jwt.verify')->group(function() {
        Route::get('/user-info', 'Auth\AuthController@me');
        Route::post('/logout', 'Auth\AuthController@logout');

        // Product
        Route::get('/get-product', 'ProductController@index'); //get all product by client
        Route::post('/get-product-admin', 'ProductController@getListByAdmin'); //get product by admin
        Route::post('/add-product', 'ProductController@create'); //get all product for client
        Route::post('/update-product', 'ProductController@edit');
        Route::post('/delete-product', 'ProductController@delete');

        // Role
        Route::post('/get-role', 'UserManagement\RoleController@index');
        Route::post('/get-detail-role', 'UserManagement\RoleController@detail');
        Route::post('/add-role', 'UserManagement\RoleController@create');
        Route::post('/update-role', 'UserManagement\RoleController@update');
        Route::post('/delete-role', 'UserManagement\RoleController@delete');

        // Permission
        Route::get('/get-permission', 'UserManagement\PermissionController@getAllPermissions');
        Route::post('/add-permission', 'UserManagement\PermissionController@create');
        Route::post('/update-permission', 'UserManagement\PermissionController@update');
        Route::post('/delete-permission', 'UserManagement\PermissionController@delete');
        Route::post('/user-role-permission', 'UserManagement\PermissionController@userWithRoleAndPermissios');
        
        // Cart
        Route::get('/get-cart', 'CartController@index');
        Route::post('/add-cart', 'CartController@create');
        Route::post('/update-cart', 'CartController@edit');
        Route::post('/delete-cart', 'CartController@delete');

        // Order
        Route::get('/get-order', 'OrderController@index');
        Route::post('/add-order', 'OrderController@create');
        Route::post('/cancel-order', 'OrderController@cancel');
        Route::post('/checkout-order', 'OrderController@checkout');
        Route::post('/payment-order', 'OrderController@payment');

        // User
        Route::post('/get-user', 'UserManagement\UserController@index');
        Route::post('/get-detail-user', 'UserManagement\UserController@detail');
        Route::post('/add-user', 'UserManagement\UserController@create');
        // Route::post('/update-user', 'UserManagement\UserController@update');
        // Route::post('/delete-user', 'UserManagement\UserController@delete');


        // ....
    });
    
});
