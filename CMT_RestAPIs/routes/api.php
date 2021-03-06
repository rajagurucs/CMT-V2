<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//LoginPage @ UserController

Route::post('register', 'App\Http\Controllers\UserController@register');

Route::post('login', 'App\Http\Controllers\UserController@login');

Route::post('profile', 'App\Http\Controllers\UserController@getAuthenticatedUser');

Route::Post('profileUpdate', 'App\Http\Controllers\UserController@UpdateProfile');

Route::put('changePassword', 'App\Http\Controllers\UserController@changePassword');

Route::post('forgot-password', 'App\Http\Controllers\UserController@forgot_password');

Route::post('recover', 'App\Http\Controllers\UserController@recover');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'App\Http\Controllers\UserController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

//Email check using Ajax 

//Route::post('/checkemail', 'App\Http\Controllers\UserController@checkemail')->middleware('ajax');
Route::post('checkemail', 'App\Http\Controllers\UserController@checkemail');

//IRF @ IrfController

Route::post('irf_register', 'App\Http\Controllers\IrfController@irf_register');

Route::GET('irf_search/{data}', 'App\Http\Controllers\IrfController@irf_search');

Route::PUT('irf_userUpdate', 'App\Http\Controllers\IrfController@irf_userUpdate');

Route::post('irf_programUpdate', 'App\Http\Controllers\IrfController@irf_programUpdate');

Route::get('getprograms/{id}', 'App\Http\Controllers\IrfController@getprogramdetails');

Route::post('irf_addGoal', 'App\Http\Controllers\IrfController@irf_addGoal');

Route::post('irf_updateGoal', 'App\Http\Controllers\IrfController@irf_updateGoal');

Route::post('irf_deleteGoal', 'App\Http\Controllers\IrfController@irf_deleteGoal');

Route::post('irf_childAdd', 'App\Http\Controllers\IrfController@childAdd');

Route::post('irf_childUpdate', 'App\Http\Controllers\IrfController@childUpdate');

Route::post('irf_childDelete', 'App\Http\Controllers\IrfController@ChildDelete');

Route::get('gethealth_programs/{id}', 'App\Http\Controllers\IrfController@gethealth_programs');

Route::post('irf_addHealth', 'App\Http\Controllers\IrfController@irf_addHealth');

//REPORTS @ ReportController

Route::get('programreport', 'App\Http\Controllers\ReportController@programReport');

Route::get('goalreport', 'App\Http\Controllers\ReportController@goalReport');

Route::get('notesreport', 'App\Http\Controllers\ReportController@notesReport');

Route::get('reportprograms', 'App\Http\Controllers\ReportController@returnprograms');

Route::get('returncategory', 'App\Http\Controllers\ReportController@returncategory');

Route::get('returnzipcode', 'App\Http\Controllers\ReportController@returnzipcode');

//Route::put('irf_update/{user_id}', 'App\Http\Controllers\IrfController@irf_update');

//SCHEDULE @ ScheduleController

Route::post('add_schedule', 'App\Http\Controllers\ScheduleController@add_schedule');

Route::get('schedules', 'App\Http\Controllers\ScheduleController@show_all');

Route::get('schedules/{id}', 'App\Http\Controllers\ScheduleController@show');

Route::get('schedulebydate/{StartDate}', 'App\Http\Controllers\ScheduleController@show_date');

Route::put('update_schedule/{id}', 'App\Http\Controllers\ScheduleController@update_schedule');

Route::delete('delete_schedule/{id}', 'App\Http\Controllers\ScheduleController@delete_schedule');

//Admin Screen APIs @ AdminScreenController

Route::post('add_adpgm', 'App\Http\Controllers\AdminScreenController@admin_addProgram');

Route::get('show_adpgm', 'App\Http\Controllers\AdminScreenController@show_allprogram');

Route::get('show_adcatego', 'App\Http\Controllers\AdminScreenController@show_allcategory');

Route::delete('delete_adpgm', 'App\Http\Controllers\AdminScreenController@delete_program');

Route::get('show_aduser', 'App\Http\Controllers\AdminScreenController@show_alluser');

Route::delete('delete_aduser', 'App\Http\Controllers\AdminScreenController@delete_user');

//File Upload & Download @ FileController

Route::post('upload', 'App\Http\Controllers\FileController@store'); 

Route::post('addgrade', 'App\Http\Controllers\FileController@addgrade'); 

Route::post('deletefile', 'App\Http\Controllers\FileController@deleteFile'); 

Route::get('displayfiles', 'App\Http\Controllers\FileController@displayfiles'); 

Route::get('getusertype', 'App\Http\Controllers\FileController@getUsertype'); 

Route::get('showprograms', 'App\Http\Controllers\FileController@showprograms'); 

Route::post('subcribeprogram', 'App\Http\Controllers\FileController@SubscribeProgram'); 

Route::post('unsubscribeprogram', 'App\Http\Controllers\FileController@UnSubscribeProgram');

//Profile Picture @ ImageController

Route::post('store-pimg', 'App\Http\Controllers\ProfileImagesController@UploadProImg');

Route::post('show-pimg', 'App\Http\Controllers\ProfileImagesController@ShowProImg');

// Route::get('/', 'ImageController@create');

// Route::post('/', 'ImageController@store');

// Route::get('/{image}', 'ImageController@show');