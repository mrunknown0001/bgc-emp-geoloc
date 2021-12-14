<?php

use Illuminate\Support\Facades\Route;

# This test route returns all users/locations in Second mysql database
//Route::get('/test', 'TestController@test');

// Route::get('/qr', 'GeneralController@qr');

Route::get('/', function () {
    return view('login');
});


// Route::get('/email', 'MailController@sendMail');


# Login for User
Route::get('/login', 'LoginController@login')->name('login');
# Post Login for User
Route::post('/login', 'LoginController@postLogin')->name('post.login');


# Login for Admin
Route::get('/admin/login', 'LoginController@adminLogin')->name('admin.login');
#post Login for Admin
Route::post('/admin/login', 'LoginController@postAdminLogin')->name('post.admin.login');


# Login for Super Admin
Route::get('/logout', 'LoginController@logout')->name('logout');


# Admin Route Group
Route::group(['prefix' => 'a', 'middleware' => 'admin'], function () {
	# Admin Dashboard
	Route::get('/dashboard/', 'AdminController@dashboard')->name('admin.dashboard');
	# Admin Profile
	Route::get('/profile', 'AdminController@profile')->name('admin.profile');
	# Change Password
	Route::get('/change-password', 'AdminController@changePassword')->name('admin.change.password');
	Route::post('/change-password', 'AdminController@postChangePassword')->name('admin.post.change.password');
	# All Users
	Route::get('/users', 'AdminController@users')->name('admin.users');

	# Add user
	Route::get('/user/add', 'AdminController@addUser')->name('admin.add.user');
	Route::post('/user/add', 'AdminController@postAddUser')->name('admin.post.add.user');

	# Update user
	Route::get('/user/update/{id}', 'AdminController@updateUser')->name('admin.update.user');
	Route::post('/user/update/{id}', 'AdminController@postUpdateUser')->name('admin.post.update.user');

	# Punches
	Route::get('/punches', 'AdminController@punches')->name('admin.punches');

	# Purge Logs
	Route::get('/purge/logs', 'AdminController@purgeLogs')->name('admin.purge.logs');
});


# User Route Group
Route::group(['prefix' => 'm', 'middleware' => 'manager'], function () {
	# PRofile
	Route::get('/profile', 'UserController@profile')->name('user.profile');
	# Change Password
	Route::get('/change-password', 'UserController@changePassword')->name('user.change.password');
	Route::post('/change-password', 'UserController@postChangePassword')->name('user.post.change.password');
	# User Dashboard
	Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
	# Manager Employees
	Route::get('/employees', 'UserController@employees')->name('user.employees');
	Route::get('/employee/{id}/show/logs', 'UserController@employeeShowLog')->name('user.show.emp.log');
	# Manager under employees punches
	Route::get('/punches', 'UserController@punches')->name('user.punches');
	# Maps
	Route::get('/map/location/{id}', 'UserController@mapLocation')->name('user.map.location');
	# Export Logs
	Route::get('/export/logs', 'UserController@exportLogs')->name('user.export.logs');
	# All Report Lists
	Route::get('/reports', 'UserController@reports')->name('man.reports');
});


# User Route Group
Route::group(['prefix' => 'e', 'middleware' => 'employee'], function () {
	# PRofile
	Route::get('/profile', 'EmployeeController@profile')->name('emp.profile');
	# Change Password
	Route::get('/change-password', 'EmployeeController@changePassword')->name('emp.change.password');
	Route::post('/change-password', 'EmployeeController@postChangePassword')->name('emp.post.change.password');
	# User Dashboard
	Route::get('/dashboard', 'EmployeeController@dashboard')->name('emp.dashboard');
	# Log User Location and Time
	Route::get('/geoloc/punch/{lat}/{lon}', 'EmployeeController@punch')->name('emp.punch');
	# My PUnches
	Route::get('/punches', 'EmployeeController@punches')->name('emp.punches');
	# Show QR Scanner
	Route::get('/qrscanner', 'EmployeeController@qrScanner')->name('emp.qr.scanner');
	# Show Location/SubLocation
	Route::get('/location/{cat}/{id}', 'EmployeeController@auditable')->name('emp.auditable');
	# Submit Report Route
	Route::post('/report/submit', 'ReportController@submit')->name('submit.report');
	Route::get('/report/submit', function () {
		return redirect()->route('emp.qr.scanner');
	});
	# My Reports | Reports Submitted
	Route::get('/reports', 'ReportController@reports')->name('reports');
	# Reprot Details
	Route::get('/report/detail/{id}', 'ReportController@reportDetail')->name('report.details');
});
