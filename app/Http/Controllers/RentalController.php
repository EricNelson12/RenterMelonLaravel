<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals () {
        $rentals = DB::select('select title, price, description,
                               area, address, link, datedAdded from rental;');
        $var = 5;
        return view('rentals', ['rentals' => $rentals]);
    }

    function showPriceSortedDesc () {
      $rentals = DB::select('select title, price, description,
                             area, address, link, datedAdded
                             from rental
                             order by price desc;');
      return view('rentals', ['rentals' => $rentals]);
    }

    function showPriceSortedAsc () {
      $rentals = DB::select('select title, price, description,
                             area, address, link, datedAdded
                             from rental
                             order by price asc;');
      return view('rentals', ['rentals' => $rentals]);
    }

    function showLocSortedDesc () {
      $rentals = DB::select('select title, price, description,
                             area, address, link, datedAdded
                             from rental
                             order by area desc;');
      return view('rentals', ['rentals' => $rentals]);
    }

    function showLocSortedAsc () {
      $rentals = DB::select('select title, price, description,
                             area, address, link, datedAdded
                             from rental
                             order by area asc;');
      return view('rentals', ['rentals' => $rentals]);
    }
}
