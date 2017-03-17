<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals ($sort=false, $type=null, $order=null, $keywords=null) {
        $sql = 'select * from rental';
        if ($sort !== false) {
            $sql .= ' order by '. $type .' '. $order;
        }
        $rentals = DB::select($sql);
        return view('rentals', ['rentals' => $rentals, 'sorted' => false]);
    }

    function showRental ($rID) {
        $sql = 'select * from rental where rID = ' . $rID;
        $rental = DB::select($sql);
        return view('rentals.rental', ['rental' => $rental]);
    }

    function showSorted ($type, $order) {
        $rentals = DB::select('select *
                             from rental
                             order by '. $type .' '. $order);
        $sorted = true;
        return view('rentals', ['rentals' => $rentals, 'sorted' => true]);
    }

    function showSearched ($keywords) {
        $keywords = explode(" ", $keywords);
        $sql = 'select * from rental where title like
        "%' . $keywords[0] . '%" or description like "%' . $keywords[0] . '%" ';
        // append the SQL statement if there is more than one keyword
        if ( sizeof($keywords) > 1 ) {
            for ($i = 1; $i < sizeof($keywords); $i++) {
                $sql .= 'or title like "%' . $keywords[$i]
                . '%" or description like "%' . $keywords[$i] . '%"';
            }
        }
        $rentals = DB::select($sql);
        return view('rentals', ['rentals' => $rentals]);
    }
}
