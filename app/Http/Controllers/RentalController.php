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
        $sorry = DB::select("select MAX(price) as maxprice, MIN(price) as minprice,
            MAX(bed) as maxbeds, MAX(bath) as maxbaths from rental");
        foreach ($sorry as $yep) {
            $maxprice = $yep->maxprice;
            $minprice = $yep->minprice;
            $maxbeds = $yep->maxbeds;
            $maxbaths = $yep->maxbaths;
        }
        return view('rentals', [
            'rentals' => $rentals,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'maxbeds' => $maxbeds,
            'maxbaths' => $maxbaths,
        ]);
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

        // Get the maximum and minimum prices from the database to be used for the slider that doesn't work
        $sorry = DB::select("select MAX(price) as maxprice, MIN(price) as minprice,
            MAX(bed) as maxbeds, MAX(bath) as maxbaths from rental");
        foreach ($sorry as $yep) {
            $maxprice = $yep->maxprice;
            $minprice = $yep->minprice;
            $maxbeds = $yep->maxbeds;
            $maxbaths = $yep->maxbaths;
        }




        if (Auth::check()){
            $id = Auth::user()->getId();
        } else {
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

        // I like these conditionals far less than you think
        // If the checkboxes are different then evaluate them and add SQL
        if (Request::input('smoke') !== Request::input('nosmoke')) {
                if ( Request::input('smoke') == true ){
                $sql .= "smoke = true and ";
                $smoke = 1;
            } else {
                $smoke = 0;
            }
            if (Request::input('nosmoke') == true){
                $sql .= "smoke = false and ";
                $nosmoke = 1;
            } else {
                $nosmoke = 0;
            }
        /*
        * This is where things get strange. The way I thought about it was
        * if both checkboxes contain the same value then a user does
        * not make a choice about the type of apartment. In SQL this
        * would translate to an or condition as in "smoking or non-smoking".
        * But that would be every rental. "smoking and non-smoking"
        * would be no rentals. So no SQL is added at all. But the
        * checkboxes should not change when untouched so values are
        * still passed to them.
        */
        } elseif (Request::input('smoke') == Request::input('nosmoke')) {
            if (Request::input('smoke') == true) {
                $nosmoke = 1;
                $smoke = 1;
            }
            elseif (Request::input('smoke') == false) {
                $nosmoke = 0;
                $smoke = 0;
            }
        }
        // Yeah...
        if (Request::input('pets') !== Request::input('nopets')) {
            if (Request::input('pets') == true) {
                $sql .= "pets = true and ";
                $pets = 1;
            } else {
                $pets = 0;
            }
            if (Request::input('nopets') == true) {
                $sql .= "pets = false and ";
                $nopets = 1;
            } else {
                $nopets = 0;
            }
        } elseif (Request::input('pets') == Request::input('nopets')) {
            if (Request::input('pets') == true) {
                $nopets = 1;
                $pets = 1;
            }
            elseif (Request::input('pets') == false) {
                $nopets = 0;
                $pets = 0;
            }
        }
        // It's bad...
        if (Request::input('furn') !== Request::input('nofurn')) {
            if (Request::input('furn') == true) {
                $sql .= "furn = true and ";
                $furn = 1;
            } else {
                $furn = 0;
            }
            if (Request::input('nofurn') == true) {
                $sql .= "furn = false and ";
                $nofurn = 1;
            } else {
                $nofurn = 0;
            }
        } elseif (Request::input('furn') == Request::input('nofurn')) {
            if (Request::input('furn') == true) {
                $nofurn = 1;
                $furn = 1;
            }
            elseif (Request::input('furn') == false) {
                $nofurn = 0;
                $furn = 0;
            }
        }

        $bed = Request::input('bed');
        $sql .= "bed > $bed and ";

        $bath = Request::input('bath');
        $sql .= "bath > $bath and ";

        if (Request::input('maxpricewanted') !== null) {
            $maxmpricewanted = Request::input('maxpricewanted');
            $sql .= "price < $maxmpricewanted and ";
        }

        // Create the array of filters
        $filters = array (
            'smoke' => $smoke,
            'pets' => $pets,
            'furn' => $furn,
            'nosmoke' => $nosmoke,
            'nopets' => $nopets,
            'nofurn' => $nofurn,
            'bed' => $bed,
            'bath' => $bath,
            'maxpricewanted' => $maxmpricewanted,
        );

        // You can never nobe too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);

        return view('rentals', [
            'rentals' => $rentals,
            'filters' => $filters,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'maxbeds' => $maxbeds,
            'maxbaths' => $maxbaths,
            'sql' => $sql
        ]);
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
