<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::get('admin/reset-password', function () { return view('auth.passwords.reset-admin');});
Route::post('admin/reset-password', function () { return view('auth.passwords.reset-admin');});


 /* ----------------------------------------Admin Routes------------------------------------ */
    Route::prefix('admin')->group(function() {
      Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
      Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
      Route::post('/reset_admin','Auth\AdminLoginController@reset_password')->name('admin.reset.submit');
      Route::post('/confirm_reset','Auth\AdminLoginController@confirm_reset')->name('admin.confirm_reset.submit');
      Route::get('/', 'AdminController@index')->name('admin.dashboard');
      Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
      Route::get('step-1', 'Admin\StepController@step_1');
      Route::get('step-2', 'Admin\StepController@step_2');
      Route::get('step-3', 'Admin\StepController@step_3');
      Route::get('/loc/{id}', 'Admin\StepController@location_user');
      Route::get('/loc_1/{id}', 'Admin\StepController@location_user1');
      Route::get('hod_cc', 'Admin\StepController@hod_cc');
      Route::get('oc', 'Admin\StepController@oc');
      Route::get('oc_structure', 'Admin\StepController@oc_structure');
      Route::post('oc_structure_1', 'Admin\StepController@oc_structure_1');
      Route::get('hod_cc_allocation', 'Admin\StepController@hod_cc_allocation');
      Route::get('assign-admins', 'Admin\StepController@assign_module_admins');
      Route::get('module_info', 'Admin\StepController@assign_module_admins');
    });
    
    //Admin-Step Ajax Calls
    Route::post('step', 'Admin\StepController@ajax_step_controller');

Route::group(['middleware' => ['auth']], function() {

  /* ----------------------------------------Stationary Routes------------------------------------ */
        Route::get('items', 'StationaryController@index');
        Route::get('my-request_st', 'StationaryController@my_request');
        Route::get('item-request', 'StationaryController@item_request');
    //Ajax Call 
        Route::post('stationary_ajax', 'StationaryController@ajax_stationary_controller');
    //Forms Submit
        Route::post('forms_stationary', 'StationaryController@forms_stationary_functions');


 /* ----------------------------------------Approvals Routes------------------------------------ */
    Route::get('approvals', 'ApprovalController@index');
     //Ajax Call 
     Route::post('approval_ajax', 'ApprovalController@ajax_approval_controller');
     Route::get('issues-approvals', 'ApprovalController@issues_approvals');


  /* ----------------------------------------Taxi Routes------------------------------------ */
     Route::get('taxi-settings', 'TaxiController@taxi_settings');
     Route::get('taxi-details', 'TaxiController@taxi_details');
     Route::get('taxi-request', 'TaxiController@taxi_requests');
     Route::get('taxi-request-form', 'TaxiController@taxi_requests_form');
     Route::get('taxi-schedule', 'TaxiController@taxi_schedule');
     Route::get('taxi-closing', 'TaxiController@taxi_closing');
     Route::get('taxi-old_records', 'TaxiController@taxi_old_records');
     Route::get('taxi-report', 'TaxiController@taxi_reports');
     //Module-Settings AJAX Calls
    Route::post('taxi-ajax', 'TaxiController@ajax_taxi_controller');
    //Forms Submit
    Route::post('forms_taxi', 'TaxiController@forms_taxi_functions');
    Route::post('report_taxi', 'TaxiController@forms_report_taxi');
    Route::post('taxi_old_records_view', 'TaxiController@taxi_old_records_view');

/* ----------------------------------------Gatepass Routes------------------------------------ */
     Route::get('gp_settings', 'GatepassController@index');
     Route::get('my-request_gp', 'GatepassController@my_request');
     Route::get('gp-request', 'GatepassController@gp_request');
     Route::get('gp_close', 'GatepassController@gp_close');
     //Ajax Call 
     Route::post('gatepass_ajax', 'GatepassController@ajax_gatepass_controller');
     //Forms Submit
     Route::post('gatepass_settings', 'GatepassController@settings');
     
/* ----------------------------------------Productions Routes------------------------------------ */
        Route::get('production', 'ProductionController@index');
        Route::get('edit-production', 'ProductionController@edit_production');
        Route::get('production-schedule', 'ProductionController@schedule_production');
        //Forms Submit
        Route::post('production_settings', 'ProductionController@settings');
        Route::post('edit_production_form', 'ProductionController@edit_production_form');
        Route::post('production_schedule_chart', 'ProductionController@production_schedule_chart');
        //Ajax Call 
        Route::post('production_ajax', 'ProductionController@ajax_production_controller');

/* ----------------------------------------Safety Routes------------------------------------ */
    Route::get('shoes', 'SafetyController@index');
    Route::get('my-request_shoes', 'SafetyController@my_request');
    Route::get('shoes-request', 'SafetyController@shoes_request');
    //Ajax Call 
    Route::post('safety_ajax', 'SafetyController@ajax_safety_controller');
    //Forms Submit
    Route::post('forms_safety_shoes', 'SafetyController@forms_safety_shoes');
        

});