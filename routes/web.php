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

// routes for returning rental views
Route::get('rentals/', 'RentalController@showRentals');
Route::get('rental/{id}', 'RentalController@showRental');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/terms', function () {
    return view('terms');
});

Route::post('/report/{id}/{rID}/{reportType}/{desc}', ['as' => '' ,'uses' => 'RentalController@reportScam']);

Route::get('/admin/dashboard', ['middleware' => ['auth', 'admin'], function () {
    return view('admin.dashboard');
}]);

Route::get('/admin/reported', ['middleware' => ['auth', 'admin'], 'uses' => 'RentalController@showReported' ]);
