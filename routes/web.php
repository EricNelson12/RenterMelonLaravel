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

// routes for returning rental views
Route::get('/rentals', 'RentalController@showRentals');
Route::get('/rentals/sorted/{type}+{order}', ['uses' => 'RentalController@showSorted']);
Route::get('/rentals/rental/{id}', 'RentalController@showRental');
Route::post('/rentals/search?{keywords}', 'RentalController@showSearched');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/terms', function () {
    return view('terms');
});
