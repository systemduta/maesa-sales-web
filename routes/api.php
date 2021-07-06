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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'API\Auth\LoginController@login');
Route::post('/forgot', 'API\Auth\ForgotController@forgot');
Route::post('/logout', 'API\Auth\LogoutController@logout');

Route::get('/profile', 'API\UserController@profile');

//Product
Route::get('/product', 'API\ProductController@index');
Route::get('/product/{id}', 'API\ProductController@show');

//Transaction
Route::get('/transactions', 'API\TransactionController@index');
Route::get('/transactions/detail/{id}', 'API\TransactionController@show');
Route::post('/transactions', 'API\TransactionController@store');
Route::put('/transactions/{id}', 'API\TransactionController@update');
Route::delete('/transactions/{id}', 'API\TransactionController@destroy');

//Notification
Route::get('/notification','API\NotificationController@listNotification');
