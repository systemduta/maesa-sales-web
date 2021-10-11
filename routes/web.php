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
    try {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        dd("Success to cache:clear");
    } catch (Exception $exception){
        throw $exception;
    }
});
Route::get('config_clear', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        dd("Success to config:clear");
    } catch (Exception $exception){
        throw $exception;
    }
});
Route::get('storage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        dd("Success to storage");
    } catch (Exception $exception){
        throw $exception;
    }
});

Route::get('migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate');
        dd("Success to migrate");
    } catch (Exception $exception){
        throw $exception;
    }
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
Route::put('update_profile', 'UserController@update')->name('update_profile');

//customer
Route::get('/customer', 'CustomerController@index')->name('customers.index');
Route::get('/customer/create', 'CustomerController@create')->name('customers.create');
Route::post('/customer/store', 'CustomerController@store')->name('customers.store');
Route::get('/customer/edit/{id}', 'CustomerController@edit')->name('customers.edit');
Route::put('/customer/update/{id}', 'CustomerController@update')->name('customers.update');
Route::get('/customer/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');
Route::get('/customer/coba', 'CustomerController@coba');

//notification
Route::get('/notifications','NotificationHistoryController@listNotification');

Route::resource('visits', 'VisitController');
