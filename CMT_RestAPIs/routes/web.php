<?php

use Illuminate\Support\Facades\Route;

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

Route::get('user/verify/{verification_code}', 'App\Http\Controllers\UserController@verifyUser');

Route::get('user/verify/resend/{id}', 'App\Http\Controllers\UserController@resendVerification');

Route::get('pwd/reset/{token}', 'App\Http\Controllers\UserController@resendVerification'); /// to do

Route::view('forgot_password', 'auth.reset_password')->name('password.reset');
