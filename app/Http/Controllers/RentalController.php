<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals () {
        // TODO: select max and min size and price for sliders
        $rentals = DB::table('rental')->get();
        return view('rentals', ['rentals' => $rentals]);
    }

    // Take the user to a single rental page
    function showRental ($rID) {
        $rental = DB::table('rental')->where('rID', $rID)->first();
        return view('rentals.rental', ['rental' => $rental]);
    }

    // TODO: make a function that adds scams to a the report table
    function reportScam ($rID) {
        // $sql = '';
    }
}
