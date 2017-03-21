<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

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

    // Insert a reported ad into a the database
    function reportScam () {
        $id = Auth::user()->getId();
        $rID = Request::input('rID');
        $reportType = Request::input('reportType');
        $desc = Request::input('desc');
        DB::table('report')->insert(
            ['id' => $id, 'rID' => $rID, 'reportType' => $reportType, 'description' => $desc]
        );
        return view('/home');
    }

    // Show a list of reported ads if authorized
    function showReported () {
        $reported = DB::table('report')->get();
        return view('admin.reported', ['reported' => $reported]);
    }

    // 
    function filterAds () {

    }
}
