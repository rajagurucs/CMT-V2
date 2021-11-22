<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\tb_PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RequestHelper;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UpdatePwdController extends Controller
{
    //
    // public function updatePassword(RequestHelper $request){
    //     return $this->validateToken($request)->count() > 0 ? $this->changePassword($request) : $this->noToken();
    // }

    // private function validateToken($request){
    //     return DB::table('password_resets')->where([
    //         'email' => $request->email,
    //         'token' => $request->passwordToken
    //     ]);
    // }

    // private function noToken() {
    //     return response()->json([
    //       'error' => 'Email or token does not exist.'
    //     ]);
    // }

    // private function changePassword($request) {
    //     $user = User::whereEmail($request->email)->first();
    //     $user->update([
    //       'password'=>bcrypt($request->password)
    //     ]);
    //     $this->validateToken($request)->delete();
    //     return response()->json([
    //       'data' => 'Password changed successfully.'
    //     ]);
    // }  

    public function updatePassword(Request $request)
    {
      $validator = Validator::make($request->json()->all() , [        
        'token' => 'required',
        'password' => ['required','string','min:6','regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',]      // must contain at least one digit 
            ]);
    
    if($validator->fails())
    {
        return response()->json($validator->errors()->toJson(), 400);
    } 

    $token =  $request->json()->get('token');
    // $email =  $request->json()->get('email');
    $password = $request->json()->get('password');

    // $check = tb_PasswordReset::select('token')
    //                         ->where('email',$email)
    //                         ->value('token');


    //                         return response()->json(['success'=> false,'message'=> $check]);                     
    $check = tb_PasswordReset::select('email')
                            ->where('token',$token)
                            ->first();
  if(is_null($check))
  {
    return response()->json(['success'=> false,'message'=> 'token Not valid.']);
  }
  else
  {
    $email = tb_PasswordReset::select('email')
                            ->where('token',$token)
                            ->value('email');
    $data6=User::where('email',$email)                            
                            ->update([
                              'password' => Hash::make($password)]);
    DB::table('password_resets')->where('email', $email)            
                              ->delete(); 
        
                              return response()->json(['success'=> true,'message'=> 'Password updated sucessfully ']);
  }

}
}