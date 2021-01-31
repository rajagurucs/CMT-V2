<?php

namespace App\Http\Controllers;

use App\Models\tb_init_user_details;
use App\Models\tb_child_details;
use App\Models\tb_init_user_program_details;
use App\Models\tb_init_user_extra_details;
use App\Models\tb_init_user_goals;
//use App\Models\tb_community_programs;
//use App\Models\tb_init_user_health_details;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Routing\Controller as BaseController;

class IrfController extends BaseController
{
    //
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function irf_register(Request $request)
    {
        $validator = Validator::make($request->json()->all() , 
        [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'streetAddress' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zipCode' => 'required|string|max:255',
            'phoneCell' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'firstLang' => 'required|string|max:255',
            'EmerContactName' => 'required|string|max:255',
            'EmerContactNo' => 'required|string|max:255',
            'aboutUs' => 'required|string|max:255',
            'ChildValue' => 'required|string|max:255',
            'myHealth' => 'required|string|max:255',
            'myLifeSatisfaction' => 'required|string|max:255',
            'mySocialNetwork' => 'required|string|max:255',
            'myCommunityNetwork' => 'required|string|max:255',
            'myStressLevel' => 'required|string|max:255',
            'myHealthIssues' => 'required|string|max:255',
            'myFamilyDoctor' => 'required|string|max:255',
            'myVisitToFamilyDoctor' => 'required|string|max:255',
            'myVisitToClinic' => 'required|string|max:255',
            'myVisitToEmergency' => 'required|string|max:255',
            'myVisitToHospital' => 'required|string|max:255',
            'myDiseaseAwareness' => 'required|string|max:255',
            'myCmtProgramAwareness' => 'required|string|max:255',
            'myPhysicalActiveness' => 'required|string|max:255',
            
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 

            DB::beginTransaction();

        try
        {
             $user = tb_init_user_details::create([
            'firstName' => $request->json()->get('firstName'),
            'middleName' => $request->json()->get('middleName'),
            'lastName' => $request->json()->get('lastName'),
            'gender' => $request->json()->get('gender'),
            'age' => $request->json()->get('age'),
            'streetAddress' => $request->json()->get('streetAddress'),
            'city' => $request->json()->get('city'),
            'province' => $request->json()->get('province'),
            'country' => $request->json()->get('country'),
            'zipCode' => $request->json()->get('zipCode'),
            'phoneHome' => $request->json()->get('phoneHome'),
            'phoneCell' => $request->json()->get('phoneCell'),
            'phoneWork' => $request->json()->get('phoneWork'),
            'email' => $request->json()->get('email'),
            'firstLang' => $request->json()->get('firstLang'),
            'EmerContactName' => $request->json()->get('EmerContactName'),
            'EmerContactNo' => $request->json()->get('EmerContactNo'),
            'aboutUs' => $request->json()->get('aboutUs'),
            'ChildValue' => $request->json()->get('ChildValue'),
            'notes' => $request->json()->get('notes')            
            ]);

                $ChildDetails = $request->json()->get('child_program');
                
                foreach($ChildDetails as $key => $title)
                {
                    $data2 = new tb_child_details();
                    $data2->childFirstname = $title['childFirstName'];
                    $data2->childLastname = $title['childLastName'];
                    $data2->childDob = $title['childBirthDate'];
                    $data2->parentId = $user->id;
                    $data2->save();
                }
              //    Link::insert($data2);
            
               // return response($data2, 200);                

               $Programs = $request->json()->get('userprograms');
              
               foreach($Programs as $key => $title)
               {
                    foreach($title as $key2 => $val)
                        {
                                 $checker2 = $val['isChecked'];
                                if($checker2 == 'true')
                                    { 
                                        $data3 = new tb_init_user_program_details();
                                        $data3->programName = $key;
                                        $data3->category = $val['value'];
                                        $data3->userId = $user->id;
                                        $data3->save();
                                    }
                            }
                            
               }

               $Afterschool = $request->json()->get('after_school_program');

               if($Afterschool == 'yes')
               {
                $data4 = new tb_init_user_program_details();
                $data4->programName = "AfterSchool";
                $data4->category = "AfterSchool";
                $data4->userId = $user->id;
                $data4->save();
               }

               $other = $request->json()->get('Others');

               if(!empty($other)) 
               {
                $data5 = new tb_init_user_program_details();
                $data5->programName = "Other";
                $data5->category = $other;
                $data5->userId = $user->id;
                $data5->save();
               }
                          
               $memdetails = tb_init_user_extra_details::create([
                'myHealth' => $request->json()->get('myHealth'),
                'myLifeSatisfaction' => $request->json()->get('myLifeSatisfaction'),
                'mySocialNetwork' => $request->json()->get('mySocialNetwork'),
                'myCommunityNetwork' => $request->json()->get('myCommunityNetwork'),
                'myStressLevel' => $request->json()->get('myStressLevel'),
                'myHealthIssues' => $request->json()->get('myHealthIssues'),
                'myFamilyDoctor' => $request->json()->get('myFamilyDoctor'),
                'myVisitToFamilyDoctor' => $request->json()->get('myVisitToFamilyDoctor'),
                'myVisitToClinic' => $request->json()->get('myVisitToClinic'),
                'myVisitToEmergency' => $request->json()->get('myVisitToEmergency'),
                'myVisitToHospital' => $request->json()->get('myVisitToHospital'),
                'myDiseaseAwareness' => $request->json()->get('myDiseaseAwareness'),
                'myCmtProgramAwareness' => $request->json()->get('myCmtProgramAwareness'),
                'myPhysicalActiveness' => $request->json()->get('myPhysicalActiveness'),
                'cmtAgent' => $request->json()->get('LoggedAgent'),
                'userId' => $user->id
               ]);
              
               DB::commit();

            } catch (Exception $e) {
        
                Log::warning(sprintf('Exception: %s', $e->getMessage()));
        
                DB::rollBack();
            }
               //Creating Array for Response
             
               $display = $user->id;  
               //return response($display, 200);
               return response()->json(['id' => $display], 400);
    }
    // public function irf_search(Request $request)
    //  {

    //     $data = $request->get('data');

    //     $search_users = Irf::where('id', 'like', "{$data}")
    //                      ->orWhere('firstname', 'like', "{$data}")
    //                      ->orWhere('email_id', 'like', "{$data}")
    //                      ->get();

    //     //return response::json(['data' => $search_users ]);     
    //     //return response()->json(['data' => $search_users], 400);
    //     return response()->json($search_users,200 );
    // } 

    public function irf_search($data)
    {
        //  $userId = $request->json()->get('userId');

        // $photos = tb_init_user_detail::all();
        //return response($photos, 200);
        
        // $user =  tb_init_user_detail::where('userId', $userId)->first();
        //$data = $request->json()->get('data');

      // $data = $request->input('data', false);

       $search_users = tb_init_user_details::where('userId',$data)
                                           ->orwhere('email',$data)
                                           ->first();
                                          
        //Checking whether the User Query returns value             
         if(is_null($search_users)) 
        {
            //return response("User Does Not Exist",200);
            return response()->json(['success'=> false,
                                    'message'=>'User Does Not Exist'], 200);                                     
        }
        else
        {
            //Storing the result in a Array
            $resultArr = $search_users->toArray();
        }       
       
        //Getting the User Id from the Query
        $id = $resultArr['userId'];
        
        //Searching Child Details
        $search_child = tb_child_details::where('parentId',$id)->get();

        //  $resultArr2 = $search_child->toArray();

        //Counting the rows returned
        // $ChildCount = count($search_child );
        
        $ProgramDetails = tb_init_user_program_details::where('userId',$id)->get();

        $HealthDetails = tb_init_user_extra_details::where('userId',$id)->get();

        //$GoalDetails = tb_init_user_goals::where('userId',$id);

        // //Creating Array for Response
        $search['User_Details'] = $search_users;
        $search['Child_Details'] = $search_child;
        $search['Program_Details'] = $ProgramDetails;
        $search['Health_Details'] = $HealthDetails;
                  
       // return response($search,200);
        return response()->json($search, 200);
    }

    public function irf_userUpdate(Request $request)
    {
        $validator = Validator::make($request->json()->all() , [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'streetAddress' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zipCode' => 'required|string|max:255',
            'phoneCell' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'firstLang' => 'required|string|max:255',
            'EmerContactName' => 'required|string|max:255',
            'EmerContactNo' => 'required|string|max:255',   
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        } 

        $id= $request->json()->get('userId');
        
        $user=tb_init_user_details::where('userId',$id)
                            ->update([
            'firstName' => $request->json()->get('firstName'),
            'middleName' => $request->json()->get('middleName'),
            'lastName' => $request->json()->get('lastName'),
            'gender' => $request->json()->get('gender'),
            'age' => $request->json()->get('age'),
            'streetAddress' => $request->json()->get('streetAddress'),
            'city' => $request->json()->get('city'),
            'province' => $request->json()->get('province'),
            'country' => $request->json()->get('country'),
            'zipCode' => $request->json()->get('zipCode'),
            'phoneHome' => $request->json()->get('phoneHome'),
            'phoneCell' => $request->json()->get('phoneCell'),
            'phoneWork' => $request->json()->get('phoneWork'),
            'email' => $request->json()->get('email'),
            'firstLang' => $request->json()->get('firstLang'),
            'EmerContactName' => $request->json()->get('EmerContactName'),
            'EmerContactNo' => $request->json()->get('EmerContactNo'),
            'notes' => $request->json()->get('notes')            
        ]);
            return response()->json(['message'=> 'User Updated']);
    }

    public function irf_programUpdate(Request $request)
    {
        $Programs = $request->json()->get('userprograms');

        $id = $request->json()->get('userId');
              
        foreach($Programs as $key => $title)
        {
             foreach($title as $key2 => $val)
                 {
                          $checker2 = $val['isChecked'];
                          if($checker2 == 'true')
                             { 
                               $data= tb_init_user_program_details::where('userId', $id)
                                                                    ->where('category',$val['value'])
                                                                    ->first(); 
                                if(is_null($data))
                                    {
                                        $data3= tb_init_user_program_details::upsert([
                                        'programName' => $key,
                                        'category' => $val['value'],
                                        'userId' => $id],'userId',['programName','category','userId']);        
                                    }
                                }
                            else
                            {
                                DB::table('tb_init_user_program_details')->where('userId', $id)
                                                                        -> where('category', $val['value'])
                                                                        ->delete();
                            }                                        
                        }
                    }
                    $Afterschool = $request->json()->get('after_school_program');
                    $data1= tb_init_user_program_details::where('userId', $id)
                                        ->where('programName','AfterSchool')
                                        ->first();                                                   
                    if($Afterschool == 'no' and !empty($data1))
                    {
                        DB::table('tb_init_user_program_details')->where('userId', $id)
                                            ->where('programName','AfterSchool')
                                            ->delete();
                    }
                    else if($Afterschool == 'yes' and is_null($data1))
                    {
                        $data4 = new tb_init_user_program_details();
                        $data4->programName = "AfterSchool";
                        $data4->category = "AfterSchool";
                        $data4->userId = $id;
                        $data4->save();
                    }
        
                    $other = $request->json()->get('Others');
            
                    $data5= tb_init_user_program_details::where('userId', $id)
                                                        ->where('programName','Other')
                                                        ->first();

                    if(is_null($data5))
                     {
                      $data6 = tb_init_user_program_details::upsert([
                        'programName' => "Other",
                        'category' => $other,
                        'userId' => $id],'userId',['programName','category','userId']);
                      }
                      else
                      {
                        $data6=tb_init_user_program_details::where('userId',$id)
                                                ->where('programName','Other')
                                                ->update([
                                                    'programName' => "Other",
                                                    'category' => $other,
                                                    'userId' => $id]);
                      }
                      return response()->json(['message'=> 'User Program Updated']);
                 
    }

    public function irf_update($user_id)
     {
         //$getdata = $request->get('getdata');
         
         $user_id = DB::table('tb_init_user_details')->where('userId',$user_id)->first();

         if(!is_null($user_id))
         {
             //$user->update(['IsActive' => 1]);
             return response()->json(['success'=> True,
                                    'message'=> 'User Found'
                                     ]);
         }
         return response()->json(['success'=> false,
                                    'message'=> 'User Not Found'
                                     ]);
           
         
     }

     public function irf_addGoals(Request $request)
     {
         //$getdata = $request->get('getdata');
         
         $validator = Validator::make($request->json()->all() , [
            'user_goal_category_name' => 'required|string|max:255',
            'user_goal_program_name' => 'required|string|max:255',
            'user_goal_program_location' => 'required|string|max:255',
            'user_goal_program_instructor' => 'required|string|max:255',
            'user_goal_program_startdate' => 'required|string|max:255',
            'user_goal_program_enddate' => 'required|string|max:255',
            'user_goal_program_participantcomments' => 'required|string|max:255',
            'user_goal_program_additionalcomments' => 'required|string|max:255',
            'user_goal_program_status' => 'required|string|max:255',
            'user_goal_program_RatingBefore' => 'required|string|max:255',
            'user_goal_program_RatingAfter' => 'required|string|max:255',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        } 

        $id= $request->json()->get('userId');
        
        // $user=tb_init_user_goals::where('userId',$id)
        //                     ->update([
        $user = tb_init_user_goals::create([
            'userId' => $request->json()->get('userId'),
            'goalId' => $request->json()->get('goalId'),
            'user_goal_category_name' => $request->json()->get('user_goal_category_name'),
            'user_goal_program_name' => $request->json()->get('user_goal_program_name'),
            'user_goal_program_location' => $request->json()->get('user_goal_program_location'),
            'user_goal_program_instructor' => $request->json()->get('user_goal_program_instructor'),
            'user_goal_program_startdate' => $request->json()->get('user_goal_program_startdate'),
            'user_goal_program_enddate' => $request->json()->get('user_goal_program_enddate'),
            'user_goal_program_participantcomments' => $request->json()->get('user_goal_program_participantcomments'),
            'user_goal_program_additionalcomments' => $request->json()->get('user_goal_program_additionalcomments'),
            'user_goal_program_status' => $request->json()->get('user_goal_program_status'),
            'user_goal_program_RatingBefore' => $request->json()->get('user_goal_program_RatingBefore'),
            'user_goal_program_RatingAfter' => $request->json()->get('user_goal_program_RatingAfter'),             
        ]);
            return response()->json(['message'=> 'User Updated']);
         
     }

    public function showallusers()
     {
        return response()->json(Irf::all());
     }
}
