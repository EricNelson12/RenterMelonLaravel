<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals () {
        $rentals = DB::select('select * from rental;');
        return view('rentals', ['rentals' => $rentals, 'sorted' => false]);
    }

    function showRental ($rID) {
        $rental = DB::select('select title, price, description,
                              area, address, link, dateAdded
                              from rental where rID = ' . $rID . ';');
        return view('rentals.rental', ['rental' => $rental]);
    }

    function sortAsc ($sortType) {
        $rentals = DB::select('select *
                             from rental
                             order by '. $sortType .' asc;');
        $sorted = true;
        return view('rentals', ['rentals' => $rentals, 'sorted' => true]);
    }

    function sortDesc ($sortType) {
        $rentals = DB::select('select *
                             from rental
                             order by '. $sortType .' desc;');
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
