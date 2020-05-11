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
