<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'customer/transactions', 'middleware' => ['auth']], function() {
    Route::get('/all', 'Transaction\TransactionController@index')->name('transaction.index');
    Route::get('/buy', 'Transaction\TransactionController@createPurchase')->name('transaction.purchase')->middleware('customer');
    Route::get('/deposit', 'Transaction\TransactionController@createDeposit')->name('transaction.deposit')->middleware('customer');
    Route::post('/deposit', 'Transaction\TransactionController@storeDeposit')->name('transaction.store.deposit')->middleware('customer');
    Route::post('/purchase', 'Transaction\TransactionController@storePurchase')->name('transaction.store.purchase')->middleware('customer')->middleware('throttle:60,1');
});

Route::group(['prefix' => 'admin/transactions', 'middleware' => ['auth']], function(){
    Route::get('/deposits', 'Transaction\TransactionController@index')->name('transaction.index');
    Route::get('/deposit/{id}', 'Transaction\TransactionController@show')->name('transaction.show')->middleware('admin');
    Route::post('/deposit/{id}', 'Transaction\TransactionController@authorizeTransaction')->name('transaction.authorize')->middleware('admin');
});
