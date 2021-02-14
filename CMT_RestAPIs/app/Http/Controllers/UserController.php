<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;
use Illuminate\Support\Str;


use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use DB;

class UserController extends Controller
{
    //
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->json()->all() , [
            'firstName' => 'required|string|max:255',
            'middleName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'birthDate' => 'required|string|max:15',
            'gender' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',            
            'password' => 'required|string|min:6', 
            'roleType' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal' => 'required|string|max:255',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }
        $firstName = $request->firstName;
        $middleName = $request->middleName;
        $lastName = $request->lastName;
        $birthDate = $request->birthDate;
        $gender = $request->gender;
        $email = $request->email;
        $phone = $request->phone;
        $password = $request->password;
        $roleType = $request->roleType;
        $country = $request->country;
        $province = $request->province;
        $city = $request->city;
        $postal = $request->postal;

        $user = User::create([
                                'firstName' => $firstName,
                                'middleName' => $middleName,
                                'lastName' => $lastName,
                                'birthDate' => $birthDate,
                                'gender' => $gender,
                                'email' => $email,
                                'phone' => $phone,
                                'password' => Hash::make($password),
                                'roleType' => $roleType,
                                'country' => $country,
                                'province' => $province,
                                'city' => $city,
                                'postal' => $postal,
                            ]);

        // $user = User::create([
        //     'firstName' => $request->json()->get('firstName'),
        //     'middleName' => $request->json()->get('middleName'),
        //     'lastName' => $request->json()->get('lastName'),
        //     'birthDate' => $request->json()->get('birthDate'),
        //     'gender' => $request->json()->get('gender'),
        //     'email' => $request->json()->get('email'),
        //     'phone' => $request->json()->get('phone'),
        //     'password' => Hash::make($request->json()->get('password')),
        //     'roleType' => $request->json()->get('roleType'),
        //     'country' => $request->json()->get('country'),
        //     'province' => $request->json()->get('province'),
        //     'city' => $request->json()->get('city'),
        //     'postal' => $request->json()->get('postal'),
        // ]);
        $verification_code = str::random(30); //Generate verification code

        DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);

        $subject = "Please verify your email address. - CMT";
        
        Mail::send('email.verify', ['firstName' => $firstName, 'verification_code' => $verification_code],
            function($mail) use ($email, $firstName, $subject){
                $mail->from(env('MAIL_FROM_ADDRESS'), "CMT_Notification");
                // $mail->from(getenv('MAIL_FROM_ADDRESS'), "CMT_Notification");
                // $mail->from('testwebcmt@gmail.com', 'Test_CMT');
                $mail->to($email, $firstName);
                $mail->subject($subject);
            });

        //$token = JWTAuth::fromUser($user);

        //return response()->json(compact('user','token'),201);
        return response()->json([
            'success'=> true,
            'message'=> 'You have successfully registered & Verification email sent Successfully.'
        ]);
    }

    // protected function registered(Request $request, $user)
    // {
    //     $user->generateToken();
    //     return response()->json(['data' => $user->toArray()], 201);
    // }


        /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */    
    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();

        if(!is_null($check))
        {
            $user = User::find($check->user_id);

            if($user->IsActive == 1){
                // return response()->json([
                //                             'success'=> true,
                //                             'message'=> 'Account already verified..'
                //                         ]);
                return view('email/verify_message', ['message' => 'Account already verified..']);
            }
            
            // $datetime = \Carbon\Carbon::createFromFormat('m d Y H:i A', "02 08 2012 10:09PM");

            $user->update(['IsActive' => 1]);
            //$user->update(['updated_at' => now()]);
            //$user->update(['email_verified_at' => now()]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();

            // return response()->json([
            //                             'success'=> true,
            //                             'message'=> 'You have successfully verified your email address.'
            //                         ]);
            return view('email/verify_message', ['message' => 'You have successfully verified your email address.']);
        }

        // return response()->json(['success'=> false, 'error'=> "Verification code is invalid."]);
        return view('email/verify_message', ['message' => 'Verification code is invalid.']);

    }

     /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */    
    public function login(Request $request)
    {
        // $credentials = $request->json()->all();

        // try {
        //     if (! $token = JWTAuth::attempt($credentials)) {
        //         return response()->json(['error' => 'invalid_credentials'], 400);
        //     }
        //     else if($check = User::where('IsActive'== 1))
        //     {
        //         return response()->json(['error' => 'Email not yet verified'], 400);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'could_not_create_token'], 500);
        // }

        // return response()->json( compact('token') );
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $credentials['IsActive'] = 1;

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }

        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) 
    {
        $this->validate($request, ['token' => 'required']);

        try 
        {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } 
        catch (JWTException $e) 
        {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) 
        {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try 
        {
            Password::sendResetLink($request->only('email'), function (Message $message) 
            {
                $message->subject('Your Password Reset Link');
            });
        } 
        catch (\Exception $e) 
        {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }

        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
    
    public function checkemail(Request $request)
    {
        $email = $request->get('email');
        $emailcheck = User::where('email',$email)->count();               
        if($emailcheck > 0)
        {        
            return response()->json(['False'], 200);
        }
        else
        {
            return response()->json(['True'], 200);
        }       
    
    }
}
