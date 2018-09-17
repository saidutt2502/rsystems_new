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


 /* ----------------------------------------Admin Routes------------------------------------ */
    Route::prefix('admin')->group(function() {
      Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
      Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
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
    });
    //Admin-Step Ajax Calls
    Route::post('step', 'Admin\StepController@ajax_step_controller');


  /* ----------------------------------------Stationary Routes------------------------------------ */
        Route::get('items', 'StationaryController@index');
        Route::get('my-request', 'StationaryController@my_request');
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
