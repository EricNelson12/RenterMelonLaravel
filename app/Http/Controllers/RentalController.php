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

    // Takes the user to a single rental page
    function showRental ($rID) {
        $rental = DB::table('rental')->where('rID', $rID)->first();
        return view('rentals.rental', ['rental' => $rental]);
    }

    // TODO: make a function that adds reported ads to a the report table
    function reportScam ($id, $rID, $reportType, $desc) {
        DB::table('report')->insert(
            ['id' => $id, 'rID' => $rID, 'reportType' => $reportType, 'description' => $desc]
        );
    }

    function showReported () {
        $reported = DB::table('report')->get();
        return view('admin.reported', ['reported' => $reported]);
    }
}
