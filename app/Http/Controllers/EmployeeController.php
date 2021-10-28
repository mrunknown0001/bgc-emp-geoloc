<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\EmployeeLog;
use Auth;

use DataTables;

use DB;
use Hash;

use App\Http\Controllers\GeneralController as GC;

class EmployeeController extends Controller
{

    /**
     * Profile
     */
    public function profile()
    {
        return view('employee.profile');
    }


    /**
     * Change Password
     */
    public function changePassword()
    {
        return view('employee.change-password');
    }


    public function postChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();
        if(Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password Changed!');

        }
        else {
            return redirect()->back()->with('error', 'Current Password Invalid!');
        }
    }

    /**
     * Employee Dashboard
     */
    public function dashboard()
    {
    	return view('employee.dashboard');
    }



    /**
     * Pucnh Method : In or Out
     */
    public function punch(Request $request, $lat, $lon)
    {
    	if($request->ajax()) {
            $out = EmployeeLog::where('user_id', Auth::user()->id)
                            ->whereDate('created_at', date('Y-m-d', strtotime('+8 hours')))
                            ->first();

    		$log = new EmployeeLog();
    		$log->user_id = Auth::user()->id;
    		// $log->manager_id = Auth::user()->manager->id;
    		// in or out condition
    		// $log->type = GC::punchType(Auth::user()->id);
    		$log->latitude = $lat;
    		$log->longitude = $lon;
    		// $log->ip_address = $request->ip();
    		$log->ip_address = json_encode($request->ips());
    		if($log->save()) {
                return response('log saved', 200);
    		}
    		else {
    			return 'error saving log';
    		}
    	}
    	else {
    		return 'ajax error';
    	}
    }


    /**
     * punches 
     */
    public function punches (Request $request)
    {
        if($request->ajax()) {
        	$punches = EmployeeLog::where('user_id', Auth::user()->id)->get();
 
            $data = collect();
            if(count($punches) > 0) {
                foreach($punches as $j) {
                    $data->push([
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'action' => GC::getLocation($j->latitude, $j->longitude, $j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        }

    	return view('employee.punches');
    }

}
