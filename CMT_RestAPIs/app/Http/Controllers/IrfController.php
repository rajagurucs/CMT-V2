<?php

namespace App\Http\Controllers;

use App\Models\tb_init_user_details;
use App\Models\tb_child_details;
use App\Models\tb_init_user_program_details;
use App\Models\tb_init_user_extra_details;
//use App\Models\tb_community_programs;
//use App\Models\tb_init_user_goals;
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

    public function irf_search(Request $request)
    {

       $data = $request->json()->get('data');

       $search_users = tb_init_user_details::where('userId',$data)
                                           ->orwhere('email',$data)
                                           ->first();
                                          
        //Checking whether the User Query returns value             
         if(is_null($search_users))
            {
             return response("User Does Not Exist",200);
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

            //Counting the rows returned    

        
            $ProgramDetails = tb_init_user_program_details::where('userId',$id)->get();

            $HealthDetails = tb_init_user_extra_details::where('userId',$id)->get();

            //$GoalDetails = tb_init_user_goals::where('userId',$id);

        // //Creating Array for Response
            $search['User_Details'] = $search_users;
            $search['Child_Details'] = $search_child;
            $search['Program_Details'] = $ProgramDetails;
            $search['Health_Details'] = $HealthDetails;
                    
            return response($search,200);
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

    public function showallusers()
     {
        return response()->json(Irf::all());
     }
}
