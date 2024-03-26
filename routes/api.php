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
    Route::post('/send-otp', 'Otp\OtpController@sendOtp')->name('send-otp'); 
    Route::post('/verify-otp', 'Otp\OtpController@verifyOtp')->name('verify-otp'); 
    Route::get('/refresh', 'Auth\AuthController@refresh'); //refresh token
    
    Route::middleware('jwt.verify')->group(function() {
        // Menu
        Route::post('/get-list-menu', 'MenuController@getListMenu');
        Route::get('/get-list-category', 'MenuController@getListCategory');

        // Cart
        Route::post('/create-cart', 'CartController@create');
        Route::get('/get-detail-cart', 'CartController@index');
        Route::get('/get-list-cart', 'CartController@index');
        Route::post('/update-cart', 'CartController@edit');
        Route::post('/delete-cart', 'CartController@delete'); //optional

        //Order
        Route::get('/get-list-order', 'OrderController@getListOrder');
        Route::get('/get-detail-order', 'OrderController@getDetailOrder');
    });
    
});

        