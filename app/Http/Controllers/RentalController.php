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

        if (Auth::check()) {
            $id = Auth::user()->getId();
            $checkid = DB::select("select id from userfilters where id = $id");
            // Depending on the situation I get inconsistent data types from $checkid
            // So we get this unreadable garbage and I'm sorry but it always works
            foreach ($checkid as $cid){$cid2 = $cid->id;}
            if ( Request::input('clearthesefilters')!=true && isset($cid2) && $id == $cid2 )
                // return view ('test', ['test'=>$cid]);
                return $this->showMyFilteredAds($id);
        } else {
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
            $minprice = 0;
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
        return redirect('/rentals');
    }

    // Show a list of reported ads if authorized
    function showReported () {
        $reported = DB::table('report')->get();
        return view('admin.reported', ['reported' => $reported]);
    }

    //
    function filterAds () {

        // Get the maximum and minimum prices from the database to be used for the slider that works!
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

        // create an array filters based on what the user's choice
        $filters = [
            'smoke' => Request::input('smoke'),
            'pets' => Request::input('pets'),
            'furn' => Request::input('furn'),
            'nosmoke' => Request::input('nosmoke'),
            'nopets' => Request::input('nopets'),
            'nofurn' => Request::input('nofurn'),
            'bed' => Request::input('bed'),
            'bath' => Request::input('bath'),
            'maxpricewanted' => Request::input('maxpricewanted')
        ];
        // I like these conditionals far less than you think
        // If the checkboxes are different then evaluate them and add SQL
        if ($filters['smoke'] !== $filters['nosmoke']) {
                if ( $filters['smoke'] == true ){
                $sql .= "smoke = true and ";
                $smoke = 1;
            } else {
                $smoke = 0;
            }
            if ($filters['nosmoke'] == true){
                $sql .= "smoke = false and ";
                $nosmoke = 1;
            } else {
                $nosmoke = 0;
            }
        /*
        * This is where things get strange. The way I thought about it was
        * if both checkboxes contain the same value then a user does
        * not make a choice about the type of rental. In SQL this
        * would translate to an or condition as in "smoking or non-smoking".
        * But that would be every rental. "smoking and non-smoking"
        * would be no rentals. So no SQL is added at all. But the
        * checkboxes should not change when untouched so values are
        * still passed to them.
        */
        } elseif ($filters['smoke'] == $filters['nosmoke']) {
            if ($filters['smoke'] == true) {
                $nosmoke = 1;
                $smoke = 1;
            }
            elseif ($filters['smoke'] == false) {
                $nosmoke = 0;
                $smoke = 0;
            }
        }

        if ($filters['pets'] !== $filters['nopets']) {
            if ($filters['pets'] == true) {
                $sql .= "pets = true and ";
                $pets = 1;
            } else {
                $pets = 0;
            }
            if ($filters['nopets'] == true) {
                $sql .= "pets = false and ";
                $nopets = 1;
            } else {
                $nopets = 0;
            }
        } elseif ($filters['pets'] == $filters['nopets']) {
            if ($filters['pets'] == true) {
                $nopets = 1;
                $pets = 1;
            }
            elseif ($filters['pets'] == false) {
                $nopets = 0;
                $pets = 0;
            }
        }

        if ($filters['furn'] !== $filters['nofurn']) {
            if ($filters['furn'] == true) {
                $sql .= "furn = true and ";
                $furn = 1;
            } else {
                $furn = 0;
            }
            if ($filters['nofurn'] == true) {
                $sql .= "furn = false and ";
                $nofurn = 1;
            } else {
                $nofurn = 0;
            }
        } elseif ($filters['furn'] == $filters['nofurn']) {
            if ($filters['furn'] == true) {
                $nofurn = 1;
                $furn = 1;
            }
            elseif ($filters['furn'] == false) {
                $nofurn = 0;
                $furn = 0;
            }
        }

        $bed = $filters['bed'];
        $sql .= "bed > $bed and ";

        $bath = $filters['bath'];
        $sql .= "bath > $bath and ";

        if ($filters['maxpricewanted'] !== null) {
            $maxpricewanted = $filters['maxpricewanted'];
            $sql .= "price < $maxpricewanted and ";
        }

        // You can never nobe too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);

        $filters = [
            'smoke' => $smoke,
            'pets' => $pets,
            'furn' => $furn,
            'nosmoke' => $nosmoke,
            'nopets' => $nopets,
            'nofurn' => $nofurn,
            'bed' => $bed,
            'bath' => $bath,
            'maxpricewanted' => $maxpricewanted,
        ];

        return view('rentals', [
            'rentals' => $rentals,
            'filters' => $filters,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'maxbeds' => $maxbeds,
            'maxbaths' => $maxbaths,
        ]);
    }

    function showMyFilteredAds () {
        $id = Auth::user()->getId();
        $sorry = DB::select("select MAX(price) as maxprice, MIN(price) as minprice,
            MAX(bed) as maxbeds, MAX(bath) as maxbaths from rental");
        foreach ($sorry as $yep) {
            $maxprice = $yep->maxprice;
            $minprice = 0;
            $maxbeds = $yep->maxbeds;
            $maxbaths = $yep->maxbaths;
        }
        $userfilters = DB::table("userfilters")->where('id','=',$id)->first();
            // SELECT pets, furn, smoke, nopets,
            // nofurn, nosmoke, bed, bath, price
            // FROM userfilters where id = $id");

        // foreach ($userfilters as $filt) {
        $filters = [
            'smoke' => $userfilters->smoke,
            'pets' => $userfilters->pets,
            'furn' => $userfilters->furn,
            'nosmoke' => $userfilters->nosmoke,
            'nopets' => $userfilters->nopets,
            'nofurn' => $userfilters->nofurn,
            'bed' => $userfilters->bed,
            'bath' => $userfilters->bath,
            'maxpricewanted' => $userfilters->price
        ];
        // return view('test', [
        //     'filters' => $filters,
        // ]);
        // }
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

        if ($filters['smoke'] !== $filters['nosmoke']) {
                if ( $filters['smoke'] == true ){
                $sql .= "smoke = true and ";
                $smoke = 1;
            } else {
                $smoke = 0;
            }
            if ($filters['nosmoke'] == true){
                $sql .= "smoke = false and ";
                $nosmoke = 1;
            } else {
                $nosmoke = 0;
            }
        /*
        * This is where things get strange. The way I thought about it was
        * if both checkboxes contain the same value then a user does
        * not make a choice about the type of rental. In SQL this
        * would translate to an or condition as in "smoking or non-smoking".
        * But that would be every rental. "smoking and non-smoking"
        * would be no rentals. So no SQL is added at all. But the
        * checkboxes should not change when untouched so values are
        * still passed to them.
        */
        } elseif ($filters['smoke'] == $filters['nosmoke']) {
            if ($filters['smoke'] == true) {
                $nosmoke = 1;
                $smoke = 1;
            }
            elseif ($filters['smoke'] == false) {
                $nosmoke = 0;
                $smoke = 0;
            }
        }

        if ($filters['pets'] !== $filters['nopets']) {
            if ($filters['pets'] == true) {
                $sql .= "pets = true and ";
                $pets = 1;
            } else {
                $pets = 0;
            }
            if ($filters['nopets'] == true) {
                $sql .= "pets = false and ";
                $nopets = 1;
            } else {
                $nopets = 0;
            }
        } elseif ($filters['pets'] == $filters['nopets']) {
            if ($filters['pets'] == true) {
                $nopets = 1;
                $pets = 1;
            }
            elseif ($filters['pets'] == false) {
                $nopets = 0;
                $pets = 0;
            }
        }

        if ($filters['furn'] !== $filters['nofurn']) {
            if ($filters['furn'] == true) {
                $sql .= "furn = true and ";
                $furn = 1;
            } else {
                $furn = 0;
            }
            if ($filters['nofurn'] == true) {
                $sql .= "furn = false and ";
                $nofurn = 1;
            } else {
                $nofurn = 0;
            }
        } elseif ($filters['furn'] == $filters['nofurn']) {
            if ($filters['furn'] == true) {
                $nofurn = 1;
                $furn = 1;
            }
            elseif ($filters['furn'] == false) {
                $nofurn = 0;
                $furn = 0;
            }
        }

        $bed = $filters['bed'];
        $sql .= "bed > $bed and ";

        $bath = $filters['bath'];
        $sql .= "bath > $bath and ";

        if ($filters['maxpricewanted'] !== null) {
            $maxpricewanted = $filters['maxpricewanted'];
            $sql .= "price < $maxpricewanted and ";
        }

        // You can never nobe too sure of anything.
        $sql .= "1 = 1";
        $rentals = DB::select($sql);

        $filters = [
            'smoke' => $smoke,
            'pets' => $pets,
            'furn' => $furn,
            'nosmoke' => $nosmoke,
            'nopets' => $nopets,
            'nofurn' => $nofurn,
            'bed' => $bed,
            'bath' => $bath,
            'maxpricewanted' => $maxpricewanted,
        ];

        return view('rentals', [
            'rentals' => $rentals,
            'filters' => $filters,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'maxbeds' => $maxbeds,
            'maxbaths' => $maxbaths,
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
