<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Submit Report
     */
    public function submit(Request $request)
    {
    	if($request->ajax()) {
    		return response('', 500);
    	}
    }
}
