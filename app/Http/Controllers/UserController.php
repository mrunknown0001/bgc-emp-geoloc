<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use App\User;
use App\EmployeeLog;
use Auth;
use DB;
use Hash;
use App\Http\Controllers\GeneralController as GC;
use Excel;
use App\Exports\EmployeeLogExport;
use App\Report;

class UserController extends Controller
{

    /**
     * Profile
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        return view('user.change-password');
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
     * User Dashboard
     */
    public function dashboard()
    {
    	return view('user.dashboard');
    }



    public function employees (Request $request)
    {
        if($request->ajax()) {
            // Employees
            $employees = User::where('role_id', 4)->get();
 
            $data = collect();
            if(count($employees) > 0) {
                foreach($employees as $j) {
                    $data->push([
                        'first_name' => $j->first_name,
                        'last_name' => $j->last_name,
                        'action' => GC::showLogs($j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('user.employees');
    }


    public function employeeShowLog(Request $request, $id)
    {
        if($request->ajax()) {
            $punches = EmployeeLog::where('user_id', $id)
                                ->get();
 
            $data = collect();
            if(count($punches) > 0) {
                foreach($punches as $j) {
                    $data->push([
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'ip' => $j->ip_address,
                        'action' => GC::getLocation($j->latitude, $j->longitude, $j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        }
        $emp = User::findorfail($id);
        return view('user.emp-punches', ['emp' => $emp]);
    }


    public function punches(Request $request)
    {
        if($request->ajax()) {
        	$punches = EmployeeLog::all();
 
            $data = collect();
            if(count($punches) > 0) {
                foreach($punches as $j) {
                    $data->push([
                    	'emp' => $j->employee->first_name . ' ' . $j->employee->last_name,
                        'date_time' => date('F j, Y h:i:s A', strtotime($j->created_at)),
                        'ip' => $j->ip_address,
                        'action' => GC::getLocation($j->latitude, $j->longitude, $j->id)
                    ]);
                }
            }
            return DataTables::of($data)
                    ->rawColumns(['action'])
                    ->make(true);

        }

    	return view('user.punches');
    }


    public function exportLogs()
    {
        $logs = new EmployeeLogExport();
        $filename = date('F j, Y', strtotime(now())) . '.xlsx';
        return Excel::download($logs, $filename);
    }



    public function mapLocation($id)
    {
        if(Auth::user()->role_id == 4) {
            return redirect()->back()->with('info', 'User Not Able to View Map.');
        }
        $log = EmployeeLog::findorfail($id);
        $lat = $log->latitude;
        $lon = $log->longitude;
        return view('user.location', ['lat' => $lat, 'lon' => $lon, 'log' => $log]);
    }


    public function reports(Request $request)
    {
        // if($request->ajax()) {
            $reports = Report::orderBy('created_at', 'desc')->get();
 
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
        return view('user.reports');
    }

}
