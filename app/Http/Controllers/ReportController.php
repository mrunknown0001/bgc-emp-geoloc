<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Report;
use App\ReportImage;

use Carbon\Carbon;
use Image;

use DataTables;

class ReportController extends Controller
{

	/**
	 * User Submitted Report
	 */
	public function reports(Request $request)
	{
        // if($request->ajax()) {
        	$reports = Report::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
 
            $data = collect();
            if(count($reports) > 0) {
                foreach($reports as $j) {
                    $data->push([
                    	'farm' => $j->farm->code,
                    	'location' => $j->cat == 'loc' ? $j->loc->location_code : $j->sub->location->location_code . ' - ' . $j->sub->sub_location_code,
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'action' => '<button id="view" data-id="' . $j->id . '" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> View</button>'
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        // }
		return view('employee.reports');
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

    		$report = new Report();
    		$report->user_id = Auth::user()->id;
    		$report->farm_id = '';
            $report->latitude = $request->lat;
            $report->longitude = $request->lon;
            $report->cat = $request->cat;
            if($request->cat == 'loc') {
            	$report->location_id = $request->location_id;
            }
            elseif($request->cat == 'sub') {
            	$report->sub_location_id = $request->location_id;
            }
            else {
            	return response('Error in Category Input', 501);
            }
            $report->farm_id = $request->farm;
            $report->remarks = $request->remarks;
            $report->save();

	        if($request->hasFile('upload')) {
	            $upload = $request->file('upload');
	            $ts = date('m-j-Y H-i-s', strtotime(now()));
	            $filename =  $ts . '.jpg';
	            $upload->move(public_path('/uploads/images/'), $filename);

	            $img = Image::make(public_path('uploads/images/'. $filename));  
	            // $img = Image::make($request->file('upload')->getRealPath());
	            // $timestamp = date('F j, Y H:i:s', strtotime(now()));
	            $img->text($ts, 50, 120, function($font) {  
	                $font->file(public_path('fonts/RobotoMonoBold.ttf'));  
	                $font->size(80);
	                $font->color('#ffa500');
	                $font->align('left');
	            });  

	           $img->save(public_path('uploads/images/' . $filename));  
	           $report_img = new ReportImage();
	           $report_img->report_id = $report->id;
	           $report_img->image_name = $filename;
	           $report_img->save();
	        }

	        return response('Report Submitted', 200)
                      ->header('Content-Type', 'text/plain');
    	}
    }



    public function reportDetail($id)
    {
    	$data = Report::findorfail($id);

    	return view('employee.report-details', compact('data'));
    }
}
