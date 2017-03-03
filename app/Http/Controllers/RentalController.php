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

    function showSorted () {
      $rentals = DB::select('select title, price, description,
                             area, address, link, datedAdded from rental;');
    }
}
