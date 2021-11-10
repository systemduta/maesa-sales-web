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
Route::post('/update_token','API\Auth\LoginController@update_token')->name('update_token');
Route::post('/forgot', 'API\Auth\ForgotController@forgot');
Route::post('/logout', 'API\Auth\LogoutController@logout');

//Update Profile
Route::get('/profile', 'API\UserController@profile');
Route::post('/profile/update/{id}', 'API\UserController@update');

//Product
Route::get('/product', 'API\ProductController@index');
Route::get('/product/{id}', 'API\ProductController@show');

//Transaction
Route::get('/prama_transaction', 'API\TransactionController@index_prama_transaction');
Route::post('/prama_transaction', 'API\TransactionController@store_prama_transaction');
Route::get('/transactions', 'API\TransactionController@index');
Route::get('/transactions/detail/{id}', 'API\TransactionController@show');
Route::post('/transactions', 'API\TransactionController@store');
Route::put('/transactions/{id}', 'API\TransactionController@update');
Route::delete('/transactions/{id}', 'API\TransactionController@destroy');

//Visit
Route::apiResource('visits', 'API\VisitController', [ 'as' => 'api' ]);
Route::apiResource('books', 'API\BookController', [ 'as' => 'api' ]);

//NotificationHistory
Route::get('/notifications','API\NotificationHistoryController@listNotification');

//web views
Route::get('/privacy',function (){
    return view('web_views/privacy');
});
Route::get('/performance',function (){
    return view('web_views/performance');
});

Route::get('/visit_performance',function (){
    return view('web_views/visit_performance');
});


