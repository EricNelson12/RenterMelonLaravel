<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals () {
        $rentals = DB::select('select * from rental;');
        return view('rentals', ['rentals' => $rentals, 'sorted' => false]);
    }

    function showRental ($rID) {
        $rental = DB::select('select title, price, description,
                              area, address, link, datedAdded
                              from rental where rID = ' . $rID . ';');
        return view('rentals.rental', ['rental' => $rental]);
    }

    function sortAsc ($sortType) {
      $rentals = DB::select('select *
                             from rental
                             order by '. $sortType .' asc;');
      $sorted = true;
      return view('rentals', ['rentals' => $rentals, 'sorted' => true]);
    }

    function sortDesc ($sortType) {
      $rentals = DB::select('select *
                             from rental
                             order by '. $sortType .' desc;');
      $sorted = true;
      return view('rentals', ['rentals' => $rentals, 'sorted' => true]);
    }
}
