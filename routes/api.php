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

// User SignIn
Route::post('/login', 'UserController@signIn')->name('login');

// User SignUp
Route::post('/signup', 'UserController@signUp');

// AUTH ROUTES
Route::middleware('auth:sanctum')->group(function () {

	// User Info
	Route::get('/user', function (Request $request) {
		return $request->user();
	});
	// User SignOut
	Route::get('/logout', 'UserController@signOut');

	// User Update
	Route::put('/update', 'UserController@update');

});

// Products
Route::apiResource('product', 'ProductController');

//ORDERS
// Start an Order
Route::post('order/add/{product}', 'OrdersController@startOrder');

// Retrieve Order data
Route::get('order', 'OrdersController@retrieveCart');

// Delete Order
Route::delete('order/delete', 'OrdersController@clearCart');

// Order Item increment
Route::post('order/item/increment', 'OrdersController@incrementCartItem');

// Order Item decrement
Route::post('order/item/decrement', 'OrdersController@decrementCartItem');

// Order Item remove
Route::post('order/item/remove', 'OrdersController@removeFromCart');
