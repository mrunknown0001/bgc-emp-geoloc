<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Report;
use App\ReportImage;

use Carbon\Carbon;
use Image;

class ReportController extends Controller
{

	/**
	 * User Submitted Report
	 */
	public function reports()
	{
		return 'reports';
	}

    /**
     * Submit Report
     */
    public function submit(Request $request)
    {
    	if($request->ajax()) {
    		$request->validate([
    			'upload' => 'required'
    		]);
    	}
    }
}
