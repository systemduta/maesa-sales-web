<?php

use Illuminate\Support\Facades\Route;

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

Route::get('cache_clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    dd("cache:clear");
});
Route::get('config_clear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    dd("config:clear");
});
Route::get('storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd("storage");
});

Route::get('migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    dd("migrate");
});

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes([
    'register' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//pemesanan
Route::get('/transactions', 'TransactionController@index');
Route::put('/transactions/update/{id}', 'TransactionController@update');
Route::get('/transactions/detail/{id}', 'TransactionController@show')->name('transactions.detail');
Route::delete('/transactions/{id}', 'TransactionController@destroy')->name('transactions.delete');
Route::get('/invoice/{id}', 'TransactionController@invoice')->name('invoice');

Route::post('/update_token','UserController@update_token')->name('update_token');

//test
Route::get('/test', 'TestController@index');

//customer
Route::get('/customer', 'CustomerController@index')->name('customers.index');
Route::get('/customer/create', 'CustomerController@create')->name('customers.create');
Route::get('/customer/store', 'CustomerController@store')->name('customers.store');
