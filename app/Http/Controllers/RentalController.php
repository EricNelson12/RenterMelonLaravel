<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class RentalController extends Controller
{
    function showRentals () {

        $id = Auth::user()->getId();
        // TODO: select max and min size and price for sliders
        // $rentals = DB::table('rental')->get();

        $rentals = DB::select("SELECT *  FROM rental AS R

LEFT JOIN
    (
        SELECT id As isSaved, rID As dontmatter
        FROM savedads
        WHERE id = $id
    ) AS A
ON (R.rID = A.dontmatter);
");

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

        $id = Auth::user()->getId();

        $sql = "SELECT *  FROM rental AS R
        LEFT JOIN
            (
                SELECT id As isSaved, rID As dontmatter
                FROM savedads
                WHERE id = $id
            ) AS A
        ON (R.rID = A.dontmatter) WHERE ";


        if (Request::input('smoke') == true){
            $sql .= "smoke = true and ";
        }
        if (Request::input('pets') == true){
            $sql .= "pets = true and ";
        }
        if (Request::input('furn') == true){
            $sql .= "furn = true and ";
        }

        // Just had to make sure 1 = 1. You can never be too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);
        return view('rentals', ['rentals' => $rentals]);
    }

    function saveAd($rID){




      $id = Auth::user()->getId();


      DB::table('savedads')->insert(
          ['id' => $id, 'rID' => $rID]
      );
      return redirect('/home');
    }
}
