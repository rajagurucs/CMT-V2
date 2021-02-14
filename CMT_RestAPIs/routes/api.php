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

Route::get('profile', 'App\Http\Controllers\UserController@getAuthenticatedUser');

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

Route::get('programreport', 'App\Http\Controllers\ReportController@programReport');

Route::get('goalreport', 'App\Http\Controllers\ReportController@goalReport');

Route::get('notesreport', 'App\Http\Controllers\ReportController@notesReport');

//Route::put('irf_update/{user_id}', 'App\Http\Controllers\IrfController@irf_update');

