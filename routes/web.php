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
    return view('index');
});


Route::get('/test', function () {
    return view('test');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/rentals', 'RentalController@showRentals');
Route::get('/rentals/pricedesc', 'RentalController@showPriceSortedDesc');
Route::get('/rentals/priceasc', 'RentalController@showPriceSortedAsc');
Route::get('/rentals/locdesc', 'RentalController@showPriceSortedAsc');
Route::get('/rentals/locasc', 'RentalController@showPriceSortedAsc');

// this routes register form data:
Route::post('/register', 'Auth\RegisterController@show');

// Route::post('/validate', 'Auth\RegisterController@validator');

// Route::post('/validate', 'Auth\RegisterController@show{data}');
