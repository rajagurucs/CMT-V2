<?php

namespace App\Http\Controllers;

use App\Models\tb_init_user_details;
use App\Models\tb_child_details;
use App\Models\tb_init_user_program_details;
use App\Models\tb_init_user_extra_details;
use App\Models\tb_init_user_goals;
use App\Models\tb_init_user_health_details;
//use App\Models\tb_community_programs;


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
            'email' => 'required|email|unique:tb_init_user_details,email|max:255',
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

        try{
            

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
                                        $data3->programName = $val['value'];
                                        $data3->category = $key;
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
                $data5->programName = $other;
                $data5->category = "Other";
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

               $health = tb_init_user_health_details::create([
                'userId' => $user->id
               ]);
              
               DB::commit();

            } catch (Exception $e) {
        
              //  Log::warning(sprintf('Exception: %s', $e->getMessage()));
        
                DB::rollBack();
            }
               //Creating Array for Response
             
               $display = $user->id; 
                return response()->json([
                    'success'=> true,
                    'id' => $display
                    ]);
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

     // $photos = tb_init_user_details::all();
      //return response($photos, 200);
        
       // $user =  tb_init_user_details::where('userId', $userId)->first();
       //$data = $request->json()->get('data');

      // $data = $request->input('data', false);

      $search_users = tb_init_user_details::where('userId',$data)
      ->orwhere('email',$data)
      ->first();
     
        //Checking whether the User Query returns value             
        if(is_null($search_users)) 
        {
            return response()->json([
                                    'success'=> false,
                                    'message'=>'User Does Not Exist']);
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


        // $HealthDetails = tb_init_user_extra_details::where('userId',$id)->get();
        $HealthDetails = DB::table('tb_init_user_extra_details')
            ->join('tb_init_user_health_details', 'tb_init_user_extra_details.userId', '=', 'tb_init_user_health_details.userId')
            ->where ('tb_init_user_extra_details.userId',$id)            
            ->get();



        $GoalDetails = tb_init_user_goals::where('userId',$id)->get();

        // //Creating Array for Response
        $search['User_Details'] = $search_users;
        $search['Child_Details'] = $search_child;
        $search['GoalDetails'] = $GoalDetails;
        $search['Program_Details'] = $ProgramDetails;
        $search['Health_Details'] = $HealthDetails;

        // $users = DB::table('tb_init_user_extra_details')
        //     ->join('tb_init_user_health_details', 'tb_init_user_extra_details.userId', '=', 'tb_init_user_health_details.userId')            
        //     ->get();

        //return response($search,200);
        //return response()->json($search, 200);
        return response()->json([
                                'success'=> true,
                                'data'=>$search
                                ]);
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
            return response()->json(['success'=> true,'message'=> 'User Updated']);
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
                                                                    ->where('programName',$val['value'])
                                                                    ->first(); 
                                if(is_null($data))
                                    {
                                        $data3= tb_init_user_program_details::upsert([
                                        'programName' => $val['value'],
                                        'category' => $key,
                                        'userId' => $id],'userId',['programName','category','userId']);        
                                    }
                                }
                            else
                            {
                             
                                        DB::table('tb_init_user_program_details')->where('userId', $id)
                                                                        -> where('programName', $val['value'])
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
            ->where('category','Other')
            ->first();

        if(is_null($data5))
            {
                $data6 = tb_init_user_program_details::upsert([
                        'programName' => $other,
                        'category' => "Other",
                        'userId' => $id],'userId',['programName','category','userId']);
            }
            else
            {
                $data6=tb_init_user_program_details::where('userId',$id)
                                                ->where('category','Other')
                                                ->update([
                                                    'programName' => "Other",
                                                    'category' => $other,
                                                    'userId' => $id]);
            }
                return response()->json(['success'=> true,'message'=> 'User Program Updated']);
                 
    }

    public function irf_addGoal(Request $request)
     {
        $validator = Validator::make($request->json()->all() , [
            'CategoryName' => 'required|string|max:255',
            'ProgramName' => 'required|string|max:255',
            'Location' => 'required|string|max:255',
            'Instructor' => 'required|string|max:255',
            'StartDate' => 'required|date_format:Y/m/d',
            'EndDate' => 'required|date_format:Y/m/d',
            'Status' => 'required|string|max:255',
            'RatingBefore' => 'required|string|max:255',
          
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 

        $user = tb_init_user_goals::create([
            'user_goal_category_name' => $request->json()->get('CategoryName'),
            'user_goal_program_name' => $request->json()->get('ProgramName'),
            'user_goal_program_location' => $request->json()->get('Location'),
            'user_goal_program_instructor' => $request->json()->get('Instructor'),
            'user_goal_program_startdate' => $request->json()->get('StartDate'),
            'user_goal_program_enddate' => $request->json()->get('EndDate'),
            'user_goal_program_status' => $request->json()->get('Status'),
            'user_goal_program_participantcomments' => $request->json()->get('ParticipantComments'),
            'user_goal_program_additionalcomments' => $request->json()->get('AdditionalComments'),
            'user_goal_program_RatingBefore' => $request->json()->get('RatingBefore'),
            'user_goal_program_RatingAfter' => $request->json()->get('RatingAfter'),  
            'userId' => $request->json()->get('userId')            
        ]);
         
              // return response("Goals Added", 200);
               return response()->json(['success'=> True,'message'=> 'User Goals Added']);
    }

    public function irf_updateGoal(Request $request)
    {
        
        $validator = Validator::make($request->json()->all(),
        [
            'CategoryName' => 'required|string|max:255',
            'ProgramName' => 'required|string|max:255',
            'Location' => 'required|string|max:255',
            'Instructor' => 'required|string|max:255',
            'StartDate' => 'required|date_format:Y/m/d',
            'EndDate' => 'required|date_format:Y/m/d',
            'Status' => 'required|string|max:255',
            'RatingBefore' => 'required|string|max:255',
          
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 
        
        $id= $request->json()->get('userId');
        $gid= $request->json()->get('tb_user_details_goals_update_id');
        

        $data= tb_init_user_goals::where('userId', $id)
                                    ->where('tb_user_details_goals_update_id',$gid)
                                    ->first();
        if(!empty($data))
        {
            DB::table('tb_init_user_goals')->where('userId', $id)
            ->where('tb_user_details_goals_update_id',$gid)
            ->update([
            'user_goal_category_name' => $request->json()->get('CategoryName'),
            'user_goal_program_name' => $request->json()->get('ProgramName'),
            'user_goal_program_location' => $request->json()->get('Location'),
            'user_goal_program_instructor' => $request->json()->get('Instructor'),
            'user_goal_program_startdate' => $request->json()->get('StartDate'),
            'user_goal_program_enddate' => $request->json()->get('EndDate'),
            'user_goal_program_status' => $request->json()->get('Status'),
            'user_goal_program_participantcomments' => $request->json()->get('ParticipantComments'),
            'user_goal_program_additionalcomments' => $request->json()->get('AdditionalComments'),
            'user_goal_program_RatingBefore' => $request->json()->get('RatingBefore'),
            'user_goal_program_RatingAfter' => $request->json()->get('RatingAfter')
            
        ]);
         
              // return response("Goals Added", 200);
               return response()->json(['success'=> true,'message'=> 'User Goals Added Updated']);
        }
    else
        {
             return response()->json(['success'=> false,'message'=> 'Goal Not Available']);
        } 
    }
    // public function irf_updateGoals($code)
    // {
    //     $check = DB::table('tb_init_user_goals')->where('tb_user_details_goals_update_id',$code)->first();

    // }

    public function getprogramdetails($id)
    {
        $HealthResults = DB::Table('tb_init_user_program_details')->select('programName')->where('userId',$id)
                                                                                        ->where('category','health')
                                                                                        ->pluck('programName');
                                                                                       

        $EmploymentResults = DB::Table('tb_init_user_program_details')->select('programName')->where('userId',$id)
                                                                                        ->where('category','employment')
                                                                                        ->pluck('programName');
                                                                                      
        
        $NeighbourhoodResults = DB::Table('tb_init_user_program_details')->select('programName')->where('userId',$id)
                                                                                        ->where('category','neighbourhood')
                                                                                        ->pluck('programName');
                                                                                       
                                                                                       
        $StaffResults = DB::Table('tb_init_user_program_details')->select('programName')->where('userId',$id)
                                                                                        ->where('category','staff')
                                                                                        ->pluck('programName');
                                                                                        
       
        $data1= tb_init_user_program_details::where('userId', $id)
                                            ->where('category','AfterSchool')
                                            ->first();
           if(!empty($data1))
                {

                    $AfterschoolResults = DB::Table('tb_init_user_program_details')->where('userId',$id)
                                                                                    ->where('category','AfterSchool')
                                                                                    ->pluck('programName');
                                                                                  

                    $search['HealthResults'] = $HealthResults;
                    $search['EmploymentResults'] = $EmploymentResults;
                    $search['NeighbourhoodResults'] = $NeighbourhoodResults;
                    $search['StaffResults'] = $StaffResults;
                    $search['AfterschoolResults'] = $AfterschoolResults; 
                                                                                       
                }
                else
                {
                    $search['HealthResults'] = $HealthResults;
                    $search['EmploymentResults'] = $EmploymentResults;
                    $search['NeighbourhoodResults'] = $NeighbourhoodResults;
                    $search['StaffResults'] = $StaffResults;
                }
                return response()->json([
                                        'success'=> true,
                                        'data' => $search
                                        ]);
    }

    public function irf_deleteGoal(Request $request)
    {
        $id= $request->json()->get('userId');
        $gid= $request->json()->get('tb_user_details_goals_update_id');
        $program= $request->json()->get('ProgramName');

        $data1= tb_init_user_goals::where('userId', $id)
                                    ->where('user_goal_program_name',$program)
                                    ->where('tb_user_details_goals_update_id',$gid)
                                    ->first();
        if(!empty($data1))
        {
             DB::table('tb_init_user_goals')->where('userId', $id)
                                            ->where('user_goal_program_name',$program)
                                            ->where('tb_user_details_goals_update_id',$gid)
                                            ->delete();
            return response()->json(['success'=> true,'message'=> 'Goal Deleted']); 
        }
        else
        {
             return response()->json(['success'=> false,'message'=> 'Goal Not Available']);
        } 
    }

    public function childAdd(Request $request)
    {

            $id = $request->json()->get('userId');

            $ChildDetails = $request->json()->get('child_program');
                
                foreach($ChildDetails as $key => $title)
                {
                    $data2 = new tb_child_details();
                    $data2->childFirstname = $title['childFirstName'];
                    $data2->childLastname = $title['childLastName'];
                    $data2->childDob = $title['childBirthDate'];
                    $data2->parentId = $id;
                    $data2->save();
                }
        return response()->json(['success'=> true,'message'=> 'Child Added']); 
                //return response("Child Added", 200);
        }
    public function childUpdate(Request $request)
    {
        $id = $request->json()->get('userId');

       $ChildDetails = $request->json()->get('child_program');
                
        foreach($ChildDetails as $key => $title)
        {
            $childid = $title['childId'];
            
            $data6=tb_child_details::where('parentId',$id)
            ->where('childId',$childid)
            ->update([
                'childFirstname' => $title['childFirstName'],
                'childLastname' => $title['childLastName'],
                'childDob' => $title['childBirthDate']]);
         }
        return response()->json(['success'=> true,'message'=> 'Child Updated']);
    }
    
    public function childDelete(Request $request)
    {

        $id = $request->json()->get('userId');

        $ChildDetails = $request->json()->get('child_program');
             
        foreach($ChildDetails as $key => $title)
        {
         $childid = $title['childId'];
         
         $data1= tb_child_details::where('parentId', $id)
                            ->where('childId',$childid)
                            ->first();
        if(!empty($data1))
        {
            DB::table('tb_child_details')->where('parentId', $id)
                                           ->where('childId',$childid)
                                            ->delete();
        }
        else
            {
                //return response("Child Not Available", 200); 
                return response()->json(['success'=> false,'message'=> 'Child Not Available']);
            }  
        }
        //return response("Child Deleted", 200);
        return response()->json(['success'=> true,'message'=> 'Child Deleted']);
    }    
    
    public function gethealth_programs($id)
    {
        // $HealthResults = DB::Table('tb_init_user_program_details')->select('programName')->where('userId',$id)
        //                                                           ->pluck('programName');
        // return response()->json([
        //                 'success'=> true,
        //                 'data' => $HealthResults
        //                 ]);

        $HealthResults = DB::Table('tb_init_user_program_details')
                            ->select('programName')->where('userId',$id)
                            ->where('category','health')
                            ->pluck('programName');
                                                                                       

        $EmploymentResults = DB::Table('tb_init_user_program_details')
                            ->select('programName')->where('userId',$id)
                            ->where('category','employment')
                            ->pluck('programName');
                                                                                      
        
        $NeighbourhoodResults = DB::Table('tb_init_user_program_details')
                                ->select('programName')->where('userId',$id)
                                ->where('category','neighbourhood')
                                ->pluck('programName');
                                                                                       
                                                                                       
        $StaffResults = DB::Table('tb_init_user_program_details')
                            ->select('programName')->where('userId',$id)
                            ->where('category','staff')
                            ->pluck('programName');
                                                                                        
       
        $AfterschoolResults = DB::Table('tb_init_user_program_details')
                                ->select('programName')
                                ->where('userId',$id)
                                ->where('category','AfterSchool')
                                ->pluck('programName');

        $others = DB::Table('tb_init_user_program_details')
                                ->select('programName')
                                ->where('userId',$id)
                                ->where('category','!=','Other')
                                ->orwhere('programName','==','Other') 
                                ->pluck('programName');
                                
        $search['HealthResults'] = $HealthResults;
        $search['EmploymentResults'] = $EmploymentResults;
        $search['NeighbourhoodResults'] = $NeighbourhoodResults;
        $search['StaffResults'] = $StaffResults;
        $search['AfterschoolResults'] = $AfterschoolResults; 

        return response()->json([
                            'success'=> true,
                            'data' => $others
                            ]);
    }

    public function irf_addHealth(Request $request)
    {
    //    $validator = Validator::make($request->json()->all() , [

    //     'OverallHealth' => 'required|string|max:255',
    //     'LifeSatisfaction' => 'required|string|max:255',
    //     'SocialNetwork' => 'required|string|max:255',
    //     'CommunityConnection' => 'required|string|max:255',
    //     'StressLevel' => 'required|string|max:255',
    //     'PersonalHealthIssues' => 'required|string|max:255',
    //     'FamilyDoctor' => 'required|string|max:255',
    //     'FamilyDoctorVisit' => 'required|string|max:255',
    //     'ClinicVisit' => 'required|string|max:255',
    //     'EmergencyVisit' => 'required|string|max:255',
    //     'HospitalVisit' => 'required|string|max:255',
    //     'DiseasesAwareness' => 'required|string|max:255',
    //     'CommunityAwareness' => 'required|string|max:255',
    //     'PhysicalActivity' => 'required|string|max:255',
        
    //     //'cmtagent_curr' => 'required|string|max:255',
    //     ]);

    //    if($validator->fails())
    //        {
    //            return response()->json($validator->errors()->toJson(), 400);
    //        } 

    $userId = $request->json()->get('userId'); 
    

    // $data= tb_init_user_health_details::where('userId', $userId)
    //                                     ->first();
    //     if(is_null($data))
    //     {

       

    //    $user = tb_init_user_health_details::create([
        
    //     'myhealth_curr_state' => $request->json()->get('OverallHealth'),        
    //     'mylifesatisfaction_curr_state' => $request->json()->get('LifeSatisfaction'),        
    //     'mysocialnetwork_curr_state' => $request->json()->get('SocialNetwork'),
    //     'mycommunitynetwork_curr_state' => $request->json()->get('CommunityConnection'),        
    //     'mystresslevel_curr_state' => $request->json()->get('StressLevel'),        
    //     'myhealthissues_curr_state' => $request->json()->get('PersonalHealthIssues'),        
    //     'myfamilydoctor_curr_state' => $request->json()->get('FamilyDoctor'),
    //     'myvisittofamilydoctor_curr_state' => $request->json()->get('FamilyDoctorVisit'),        
    //     'myvisittoclinic_curr_state' => $request->json()->get('ClinicVisit'),
    //     'myvisittoemergency_curr_state' => $request->json()->get('EmergencyVisit'),
    //     'myvisittohospital_curr_state' => $request->json()->get('HospitalVisit'),        
    //     'mydiseaseawareness_curr_state' => $request->json()->get('DiseasesAwareness'),        
    //     'mycmtprogramawareness_curr_state' => $request->json()->get('CommunityAwareness'),        
    //     'myphysicalactiveness_curr_state' => $request->json()->get('PhysicalActivity'),
    //     //'cmtagent_curr' => $request->json()->get('cmtagent_curr'),
                 
    //     'myhealth_curr_prog' => $request->json()->get('OverallHealth_prog'), 
    //     'mylifesatisfaction_curr_prog' => $request->json()->get('LifeSatisfaction_prog'), 
    //     'mysocialnetwork_curr_prog' => $request->json()->get('SocialNetwork_prog'), 
    //     'mycommunitynetwork_curr_prog' => $request->json()->get('CommunityConnection_prog'), 
    //     'mystresslevel_curr_prog' => $request->json()->get('StressLevel_prog'), 
    //     'myhealthissues_curr_prog' => $request->json()->get('PersonalHealthIssues_prog'), 
    //     'myfamilydoctor_curr_prog' => $request->json()->get('FamilyDoctor_prog'), 
    //     'mydiseaseawareness_curr_prog' => $request->json()->get('DiseasesAwareness_prog'), 
    //     'mycmtprogramawareness_curr_prog' => $request->json()->get('CommunityAwareness_prog'), 
    //     'myphysicalactiveness_curr_prog' => $request->json()->get('PhysicalActivity_prog'), 

    //     'userId' => $request->json()->get('userId')            
    //    ]);

    //     }
    //     else
    //     {
            $data6=tb_init_user_health_details::where('userId',$userId)                                            
                                            ->update([
        'myhealth_curr_state' => $request->json()->get('OverallHealth'),        
        'mylifesatisfaction_curr_state' => $request->json()->get('LifeSatisfaction'),        
        'mysocialnetwork_curr_state' => $request->json()->get('SocialNetwork'),
        'mycommunitynetwork_curr_state' => $request->json()->get('CommunityConnection'),        
        'mystresslevel_curr_state' => $request->json()->get('StressLevel'),        
        'myhealthissues_curr_state' => $request->json()->get('PersonalHealthIssues'),        
        'myfamilydoctor_curr_state' => $request->json()->get('FamilyDoctor'),
        'myvisittofamilydoctor_curr_state' => $request->json()->get('FamilyDoctorVisit'),        
        'myvisittoclinic_curr_state' => $request->json()->get('ClinicVisit'),
        'myvisittoemergency_curr_state' => $request->json()->get('EmergencyVisit'),
        'myvisittohospital_curr_state' => $request->json()->get('HospitalVisit'),        
        'mydiseaseawareness_curr_state' => $request->json()->get('DiseasesAwareness'),        
        'mycmtprogramawareness_curr_state' => $request->json()->get('CommunityAwareness'),        
        'myphysicalactiveness_curr_state' => $request->json()->get('PhysicalActivity'),

        'myhealth_curr_prog' => $request->json()->get('OverallHealth_prog'), 
        'mylifesatisfaction_curr_prog' => $request->json()->get('LifeSatisfaction_prog'), 
        'mysocialnetwork_curr_prog' => $request->json()->get('SocialNetwork_prog'), 
        'mycommunitynetwork_curr_prog' => $request->json()->get('CommunityConnection_prog'), 
        'mystresslevel_curr_prog' => $request->json()->get('StressLevel_prog'), 
        'myhealthissues_curr_prog' => $request->json()->get('PersonalHealthIssues_prog'), 
        'myfamilydoctor_curr_prog' => $request->json()->get('FamilyDoctor_prog'), 
        'mydiseaseawareness_curr_prog' => $request->json()->get('DiseasesAwareness_prog'), 
        'mycmtprogramawareness_curr_prog' => $request->json()->get('CommunityAwareness_prog'), 
        'myphysicalactiveness_curr_prog' => $request->json()->get('PhysicalActivity_prog'),
        ]);

        // }
        return response()->json(['success'=> True,'message'=> 'User Health Details Added']);
    }

            // $id = $request->json()->get('userId');
            // $value = new tb_init_user_health_details();
            // $OverallHealths = $request->json()->get('OverallHealth');
               
            //    foreach($OverallHealths as $key)
            //    {
            //        return response ($key,200);

            //        $value->myhealth_curr_prog = $title['myhealth_curr_prog'];
            //        $value->myhealth_curr_state = $title['myhealth_curr_state'];                   
            //    }

            // $LifeSatisfactions = $request->json()->get('LifeSatisfaction');
               
            //    foreach($LifeSatisfactions as $key => $title)
            //    {
            //        $value->mylifesatisfaction_curr_prog = $title['mylifesatisfaction_curr_prog'];
            //        $value->mylifesatisfaction_curr_state = $title['mylifesatisfaction_curr_state'];                   
            //    }

            // $SocialNetworks = $request->json()->get('SocialNetwork');
               
            //    foreach($SocialNetworks as $key => $title)
            //    {
            //        $value->mysocialnetwork_curr_prog = $title['mysocialnetwork_curr_prog'];
            //        $value->mysocialnetwork_curr_state = $title['mysocialnetwork_curr_state'];                   
            //    }
            
            // $CommunityConnections = $request->json()->get('CommunityConnection');
               
            //    foreach($CommunityConnections as $key => $title)
            //    {
            //        $value->mycommunitynetwork_curr_prog = $title['mycommunitynetwork_curr_prog'];
            //        $value->mycommunitynetwork_curr_state = $title['mycommunitynetwork_curr_state'];                   
            //    }

            // $StressLevels = $request->json()->get('StressLevel');
               
            //    foreach($StressLevels as $key => $title)
            //    {
            //        $value->mystresslevel_curr_prog = $title['mystresslevel_curr_prog'];
            //        $value->mystresslevel_curr_state = $title['mystresslevel_curr_state'];                   
            //    }

            // $PersonalHealthIssues = $request->json()->get('PersonalHealthIssues');
               
            //    foreach($PersonalHealthIssues as $key => $title)
            //    {
            //        $value->myhealthissues_curr_prog = $title['myhealthissues_curr_prog'];
            //        $value->myhealthissues_curr_state = $title['myhealthissues_curr_state'];                   
            //    }

            // $FamilyDoctor = $request->json()->get('FamilyDoctor');
               
            //    foreach($FamilyDoctor as $key => $title)
            //    {
            //        $value->myfamilydoctor_curr_prog = $title['myfamilydoctor_curr_prog'];
            //        $value->myfamilydoctor_curr_state = $title['myfamilydoctor_curr_state'];
            //        $value->FamilyDoctorVisit = $title['myvisittofamilydoctor_curr_state'];
            //        $value->ClinicVisit = $title['myvisittoclinic_curr_state'];
            //        $value->EmergencyVisit = $title['myvisittoemergency_curr_state'];
            //        $value->HospitalVisit = $title['myvisittohospital_curr_state'];
            //        $value->DiseasesAwareness = $title['mydiseaseawareness_curr_state'];   
                                   
            //    }  

            // $DiseasesAwareness = $request->json()->get('DiseasesAwareness');
               
            //     foreach($DiseasesAwareness as $key => $title)
            //     {
            //         $value->mydiseaseawareness_curr_prog = $title['mydiseaseawareness_curr_prog'];
            //         $value->mydiseaseawareness_curr_state = $title['mydiseaseawareness_curr_state'];                   
            //     }     
            
            // $CommunityAwareness = $request->json()->get('CommunityAwareness');
               
            //     foreach($FamilyDoctor as $key => $title)
            //     {
            //         $value->mycmtprogramawareness_curr_prog = $title['mycmtprogramawareness_curr_prog'];
            //         $value->mycmtprogramawareness_curr_state = $title['mycmtprogramawareness_curr_state'];                   
            //     }     
                
            // $PhysicalActivity = $request->json()->get('PhysicalActivity');
               
            //     foreach($PhysicalActivity as $key => $title)
            //     {
            //         $value->myphysicalactiveness_curr_prog = $title['myphysicalactiveness_curr_prog'];
            //         $value->myphysicalactiveness_curr_state = $title['myphysicalactiveness_curr_state'];                   
            //     }
            // //'cmtagent_curr' => $request->json()->get('AgentName'), 
            // $value->userId = $id;
            // $value->save();
    //    return response()->json(['success'=> True,'message'=> 'User Health Details Added']);
//    }


    //  {
    //      //$getdata = $request->get('getdata');
         
    //      $user_id = DB::table('tb_init_user_details')->where('userId',$user_id)->first();

    //      if(!is_null($user_id))
    //      {
    //          //$user->update(['IsActive' => 1]);
    //          return response()->json(['success'=> True,
    //                                 'message'=> 'User Found'
    //                                  ]);
    //      }
    //      return response()->json(['success'=> false,
    //                                 'message'=> 'User Not Found'
    //                                  ]);
    //  }

    public function showallusers()
     {
        return response()->json(tb_init_user_details::all());
     }
}
