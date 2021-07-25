<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;
use App\Models\User;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //
    public function forgot() 
    {
        $credentials = request()->validate(['email' => 'required|email']);

        $check = User::findOrFail($credentials);
        if($check == NULL)
        {
            return response()->json(['success'=>false,'message'=>' does not exist']);
        }
        else{

        Password::sendResetLink($credentials);

        // return $this->respondWithMessage('Reset password link sent on your email id.');
        return response()->json([
            'success'=> true,
            'message'=> 'Reset password link sent on your email id.'
        ]);}
    }
    
    


    public function reset(ResetPasswordRequest $request) {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return $this->respondBadRequest(ApiCode::INVALID_RESET_PASSWORD_TOKEN);
        }

        // return $this->respondWithMessage("Password has been successfully changed");
        return response()->json([
            'success'=> true,
            'message'=> 'Password has been successfully changed'
        ]);
    }
}
