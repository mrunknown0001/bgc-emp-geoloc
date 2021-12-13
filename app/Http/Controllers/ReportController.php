<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Report;
use App\ReportImage;

class ReportController extends Controller
{
    /**
     * Submit Report
     */
    public function submit(Request $request)
    {
    	if($request->ajax()) {
    		
    	}
    }
}
