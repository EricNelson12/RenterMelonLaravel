<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use FatalErrorException;

class FilterController extends Controller
{
    function saveFilters () {
        $id = Auth::user()->getId();
        if (Request::input('smoke') == 'on')
            $smoke = 1;
        else
            $smoke = 0;
        if (Request::input('pets') == 'on')
            $pets = 1;
        else
            $pets = 0;
        if (Request::input('furn') == 'on')
            $furn = 1;
        else
            $furn = 0;
        if (Request::input('nosmoke') == 'on')
            $nosmoke = 1;
        else
            $nosmoke = 0;
        if (Request::input('nopets') == 'on')
            $nopets = 1;
        else
            $nopets = 0;
        if (Request::input('nofurn') == 'on')
            $nofurn = 1;
        else
            $nofurn = 0;
        $bed = Request::input('bed');
        $bath = Request::input('bath');
        $maxpricewanted = Request::input('maxpricewanted');

        DB::insert(
            "INSERT INTO userfilters
            (id, pets, furn, smoke, nopets,
            nofurn, nosmoke, bed, bath, price)
            VALUES ($id, $pets, $furn, $smoke, $nopets,
            $nofurn, $nosmoke, $bed, $bath, $maxpricewanted)
            ON DUPLICATE KEY
            UPDATE pets = $pets, furn = $furn, smoke = $smoke,
            nopets = $nopets, nofurn = $nofurn, nosmoke = $nosmoke,
            bed = $bed, bath = $bath, price = $maxpricewanted
            "
        );

        return redirect ('rentals');
    }
}
