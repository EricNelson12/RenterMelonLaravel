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
        return redirect('/home');
    }

    // Show a list of reported ads if authorized
    function showReported () {
        $reported = DB::table('report')->get();
        return view('admin.reported', ['reported' => $reported]);
    }

    //
    function filterAds () {
        $sql = "select * from rental where ";

        if (Request::input('smoke') == true) {
            $sql .= "smoke = true and ";
            $smoke = true;
        } else {
            $smoke = null;
        }
        if (Request::input('pets') == true) {
            $sql .= "pets = true and ";
            $pets = true;
        } else {
            $pets = null;
        }
        if (Request::input('furn') == true) {
            $sql .= "furn = true and ";
            $furn = true;
        } else {
            $furn = null;
        }
        $filters = array('smoke' => $smoke, 'pets' => $pets, 'furn' => $furn);

        // Just had to make sure 1 == 1. You can never be too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);
        return view('rentals', ['rentals' => $rentals, 'filters' => $filters, 'requestdata' => Request::input('all')]);
    }
}
