<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use FatalErrorException;

class RentalController extends Controller
{
    function showRentals () {

        // $rentals = DB::table('rental')->get();


      if (Auth::check()){
          $id = Auth::user()->getId();
      }else{
            $id = 'NULL';
      }


        $sql = "SELECT *
        FROM rental AS R
        LEFT JOIN
            (
                SELECT id As isSaved, rID As dontmatter
                FROM savedads ";
                if ($id == true) {
                    $sql .= " WHERE id = $id ";
                }
        $sql .= " ) AS A
        ON (R.rID = A.dontmatter) ";

        $rentals = DB::select($sql);
        // Need to get the max and min price somehow. It's not pretty
        $sorry = DB::select("select MAX(price) as maxprice, MIN(price) as minprice from rental");
        foreach ($sorry as $yep) {
            $maxprice = $yep->maxprice;
            $minprice = $yep->minprice;
        }
        return view('rentals', ['rentals' => $rentals, 'minprice' => $minprice, 'maxprice' => $maxprice]);
    }

    // Takes the user to a single rental page
    function showRental ($rID) {

         $rentals = DB::select("select *, (611 + 22*furn + -156*pets + -156*smoke + 282*bed + 282*bath) as guess from rental where rID = $rID");
         foreach($rentals as $rent){
            $rental = $rent;
         }

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
        $sorry = DB::select("select MAX(price) as maxprice, MIN(price) as minprice from rental");
        foreach ($sorry as $yep) {
            $maxprice = $yep->maxprice;
            $minprice = $yep->minprice;
        }
        if (Auth::check()){
            $id = Auth::user()->getId();
        }else{
              $id = 'NULL';
        }

        $sql =
        "SELECT *
        FROM rental AS R
        LEFT JOIN
            (
                SELECT id As isSaved, rID As dontmatter
                FROM savedads
                WHERE id = $id
            ) AS A
        ON (R.rID = A.dontmatter) WHERE ";

        if (Request::input('smoke') == true){
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

        if (Request::input('nosmoke') == true){
            $sql .= "smoke = false and ";
            $nosmoke = true;
        } else {
            $nosmoke = null;
        }
        if (Request::input('nopets') == true) {
            $sql .= "pets = false and ";
            $nopets = true;
        } else {
            $nopets = null;
        }
        if (Request::input('nofurn') == true) {
            $sql .= "furn = false and ";
            $nofurn = true;
        } else {
            $nofurn = null;
        }
        if (Request::input('maxpricewanted') !== null) {
            $maxmpricewanted = Request::input('maxpricewanted');
            $sql .= "price < $maxmpricewanted and ";
        }

        $filters = array (
            'smoke' => $smoke,
            'pets' => $pets,
            'furn' => $furn,
            'nosmoke' => $nosmoke,
            'nopets' => $nopets,
            'nofurn' => $nofurn,
            'maxpricewanted' => $maxmpricewanted
        );

        // You can never nobe too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);

        return view('rentals', ['rentals' => $rentals, 'filters' => $filters, 'minprice' => $minprice, 'maxprice' => $maxprice]);
    }

    function saveAd($rID){




      $id = Auth::user()->getId();


      DB::table('savedads')->insert(
          ['id' => $id, 'rID' => $rID]
      );
      return redirect('/rentals');
    }

    function unsaveAd($rID){




      $id = Auth::user()->getId();


      DB::table('savedads')->where('id','=',$id)->where('rID', '=', $rID)->delete();

      return redirect('/rentals');
    }


}
