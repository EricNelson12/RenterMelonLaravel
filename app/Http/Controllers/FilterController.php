<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use FatalErrorException;

class FilterController extends Controller
{
    function saveFilters () {
        $id = Auth::user()->getId();
        $smoke = Request::input('smoke');
        $pets = Request::input('pets');
        $furn = Request::input('furn');
        $nosmoke = Request::input('nosmoke');
        $nopets = Request::input('nopets');
        $nofurn = Request::input('nofurn');
        $bed = Request::input('bed');
        $bath = Request::input('bath');
        $maxpricewanted = Request::input('maxpricewanted');

        DB::insert(
            "INSERT INTO userfilters
            ('id, pets, furn, smoke, nopets,
            nofurn, nosmoke, bed, bath, price')
            VALUES ()$id, $pets, $furn, $smoke, $nopets,
            $nofurn, $nosmoke, $bed, $bath, $maxpricewanted)"
        );
    }
}
