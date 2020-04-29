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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('MMS', 'SmsController');

Route::resource('Sms', 'SmsController');


Route::resource('customer', 'customerscontroller');

Route::post('customer/update', 'customerscontroller@update')->name('customer.update');

Route::get('customer/destroy/{id}', 'customerscontroller@destroy');

