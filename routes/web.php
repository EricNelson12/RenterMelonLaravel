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
Route::get('/rentals/sorted/asc+{id}', 'RentalController@sortAsc');
Route::get('/rentals/sorted/desc+{id}', 'RentalController@sortDesc');
Route::get('/rentals/rental/{id}', 'RentalController@showRental');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/terms', function () {
    return view('terms');
});
