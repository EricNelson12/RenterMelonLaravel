<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RentalController extends Controller
{
    function showRentals (Request $request) {
        $sql = 'select * from rental ';

        // check if there was a get request
        if ($request !== null) {
            // check if there was a search in the get request
            if ($request->input('search') !== null) {
                $search = $request->input('search');
                $search = explode(' ', $search);
                $sql .= $this->appendSearch($sql, $search);
            }
            // check if there was a sort in the get request
            if ($request->input('sort') !== null) {
                $sort = $request->input('sort');
                $sort = explode(' ', $sort);
                $sql .= $this->appendSort($sql, $sort);
            }
        }
        $rentals = DB::select($sql);
        return view('rentals', ['rentals' => $rentals, 'sorted' => false]);
    }

    // A helper method for appending a sort to the base SQL
    function appendSort ($sql, $sort) {
        $sql = ' order by ' . $sort[0] . ' ' . $sort[1];
        return $sql;
    }

    // A helper method for appending a search to the base SQL
    function appendSearch ($sql, $keywords) {
        $sql = ' where title like
        "%' . $keywords[0] . '%" or description like "%' . $keywords[0] . '%" ';
        // append the SQL statement if there is more than one keyword
        if ( sizeof($keywords) > 1 ) {
            for ($i = 1; $i < sizeof($keywords); $i++) {
                $sql .= 'or title like "%' . $keywords[$i]
                . '%" or description like "%' . $keywords[$i] . '%"';
            }
        }
        return $sql;
    }

    // Take the user to a single rental page
    function showRental ($rID) {
        $sql = 'select * from rental where rID = ' . $rID;
        $rental = DB::select($sql);
        return view('rentals.rental', ['rental' => $rental]);
    }
}
