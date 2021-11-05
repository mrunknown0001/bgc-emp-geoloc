<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Location; // Secondary Connection

class TestController extends Controller
{
    public function test()
    {
    	$users = DB::connection('mysql2')->table('users')->get();

    	// return $users;
    	$locations = Location::all();
    	$location = Location::find(1);
    	return $location->sub_locations;
    }
}
