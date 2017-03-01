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

Route::get('/rentals', function () {
    return view('rentals');
});

// Route::post('/validate', 'Auth\RegisterController@validator');

// Route::post('/validate', 'Auth\RegisterController@show{data}');

// Route::post('/show/{data}', 'Auth\RegisterController@show');
