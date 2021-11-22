<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Storage;
use App\Models\tb_program_files;
use App\Models\tb_init_user_program_details;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Aws\S3\S3Client;

class FileController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function store(Request $request)
    {
        $this->validate($request, [
            'Program_Name' => 'required',
            'document' => 'required|mimes:pdf,png,jpg,jpeg,doc,docx,xls,xlsx|max:9999',
            'AssignmentName' => 'required',
            'role' => 'required',
        ]);

        $programName = $request->get('Program_Name');

        $data= $request->get('AssignmentName');

        $role = $request->get('role');

        if($role == "Participant")
        {

        $userID= $request->get('email');

        $UID = User::select('IRFuserId')
        ->where('email',$userID)
        ->value('IRFuserId');

        $checkAssignmentName = tb_program_files::select('File_Loc')
                                            ->where('Program_Name',$programName)
                                            ->where('AssignmentName',$data)
                                            ->where('userId',$UID)
                                            ->first();   
                                            
        $firstName =  User::select('firstName')
                                            ->where('email',$userID)
                                            ->value('firstName');

        $lastName =  User::select('lastName')
                                            ->where('email',$userID)
                                            ->value('lastName');

        $Name = $firstName.",".$lastName;

        if(is_null($checkAssignmentName)) 
        {
            $base_location = 'user_documents';

            // Handle File Upload
            if($request->hasFile('document'))         
            {               
                $check = tb_init_user_program_details::select('program_details_id')
                ->where('programName',$programName)
                ->where('userId',$UID)
                ->first();

                if(is_null($check)) 
                {
                return response()->json(['success' => false, 'message' => 'Please Subcribe to the program first'], 200);
                }
                else
                {   
                $documentPath = $request->file('document')->store($base_location, 's3');

                $docpath1 = "https://cmtassignmentfiles.s3.ap-south-1.amazonaws.com/";

                $docpath = $docpath1.$documentPath;
    
                $filedetails = tb_program_files::create([
                    'Program_Name' => $request->get('Program_Name'),
                    'Sentfrom' => $Name,
                    'AssignmentName' => $request->get('AssignmentName'),
                    'UserType' => $role,
                    'userID' => $UID,
                    'File_Loc' => $docpath,
                ]);
    
                return response()->json(['success' => true, 'message' => 'Document successfully uploaded', 'document' => $filedetails], 200);
                }
    
            } 
            else 
            {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 200);
            }    
      
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'Assignment File already uploaded for the Program. Please upload for a different Assignment'], 200);            
        }
        
    }
    else
    {
        $userID = $request->get('email');

        $checkfilename = tb_program_files::select('File_Loc')
                                            ->where('Program_Name',$programName)
                                            ->where('AssignmentName',$data)
                                            ->first(); 
                                            
        $firstName =  User::select('firstName')
                                            ->where('email',$userID)
                                            ->value('firstName');

        $lastName =  User::select('lastName')
                                            ->where('email',$userID)
                                            ->value('lastName');

        $Name = $firstName.",".$lastName;
        
        if(is_null($checkfilename)) 
        {
            $base_location = 'user_documents';

            // Handle File Upload
            if($request->hasFile('document'))         
            {               
                
                $documentPath = $request->file('document')->store($base_location, 's3');

                $docpath1 = "https://cmtassignmentfiles.s3.ap-south-1.amazonaws.com/";

                $docpath = $docpath1.$documentPath;
    
                $filedetails = tb_program_files::create([
                    'Program_Name' => $request->get('Program_Name'),
                    'Sentfrom' => $Name,
                    'AssignmentName' => $request->get('AssignmentName'),
                    'UserType' => $role,
                    'File_Loc' => $docpath,
                ]);
    
                return response()->json(['success' => true, 'message' => 'Document successfully uploaded', 'document' => $filedetails], 200);
                } 
      
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'FileName already exist for the Assignment. Please upload with a different Assignment Name'], 200);            
        }

    }
      
    }

    public function addgrade(Request $request)
    {

        $programName = $request->json()->get('Program_Name');

        $Name1 = $request->json()->get('sentfrom');

        $email = $request->json()->get('email');

        $AssignmentName = $request->json()->get('AssignmentName'); 

        $firstName =  User::select('firstName')
        ->where('email',$email)
        ->value('firstName');

        $lastName =  User::select('lastName')
        ->where('email',$email)
        ->value('lastName');

        $Name = $firstName.",".$lastName;

        $search_userprogram = tb_program_files::select('File_Loc')
                                            ->where('Program_Name',$programName)
                                            ->where('Sentfrom',$Name1)
                                            ->where('AssignmentName',$AssignmentName)
                                            ->first();
       
        //Checking whether the User Query returns value             
        if(is_null($search_userprogram)) 
        {
              return response()->json([
                                      'success'=> false,
                                      'message'=> $Name1,
                                        ],200);
        }  
        else
        {
            $user=tb_program_files::where('Program_Name',$programName)
                                    ->where('Sentfrom',$Name1)
                                    ->where('AssignmentName',$AssignmentName)
                                    ->update([
                                            'usergrade' => $request->json()->get('usergrade'),
                                            'agentcomments' => $request->json()->get('agentcomments'),
                                            'UpdatedAgent' => $Name,
                                            'Program_Name' => $programName,
                                            ]);

            return response()->json([
                'success'=> true,
                'Data'=>'grade updated'],200);
        }
    }

    public function SubscribeProgram(Request $request)
    {
        $data= $request->json()->get('Program_Name');

        $userID = $request->json()->get('userID');

        $cat = $request->json()->get('category');
    
        $check = tb_init_user_program_details::select('program_details_id')
                                            ->where('programName',$data)
                                            ->where('userId',$userID)
                                            ->first();

        if(is_null($check)) 
        {
                                                  
            $user = tb_init_user_program_details::create([
                                                        'programName' => $data,
                                                        'category' => $cat,
                                                        'userId' => $userID,
                                                        ]);
                            
            return response()->json([
                                    'success'=> true,
                                    'message'=>'Subscribed to the Program :'.$data,
                                    ], 200);
        }
                                    
        else
        {
                                                  
            return response()->json([
                                    'success'=> false,
                                    'message'=>'User already subscribed to the program: ' .$data 
                                    ], 200); 
        }

    }

    public function UnSubscribeProgram(Request $request)
    {

        $data= $request->json()->get('Program_Name');

        $userID = $request->json()->get('userID');

        $cat = $request->json()->get('category');
    
        $check = tb_init_user_program_details::select('program_details_id')
                                            ->where('programName',$data)
                                            ->where('userId',$userID)
                                            ->first();

        if(is_null($check)) 
        {
            return response()->json([
                                    'success'=> false,
                                    'message'=>'User already Unsubscribed to the program: ' .$data 
                                    ], 200); 
        }                                 
        else
        {

            DB::table('tb_init_user_program_details')->where('userId', $userID)
                                                    ->where('programName',$data)
                                                    ->where('category',$cat)
                                                    ->delete();

            return response()->json([
                                    'success'=> true,
                                    'message'=>'UnSubscribed to the Program :'.$data,
                                    ], 200);
        }       

            return response()->json([
                                    'success'=> true,
                                    'message'=>'UnSubcribed to the Program',
                                    ], 200);

    }

    public function displayfiles(Request $request)
    {
        $data = $request->get('Program_Name');

        $email = $request->get('email');

        $role = User::select('roleType')
        ->where('email',$email)
        ->value('roleType');

        $userId = User::select('IRFuserId')
                ->where('email',$email)
                ->value('IRFuserId');

        if($role == "Participant")
            {

                $check = tb_init_user_program_details::select('program_details_id')
                                                ->where('userId',$userId)
                                                ->where('programName',$data)
                                                ->first();
        
                if(is_null($check))
                    {
                        $check = "UnSubscribed";
                        $search['UserProgramStatus'] = $check;
                        $search['MyFiles'] = [];
                        $search['Assignments'] = [];
                                    
                        return response()->json([
                                    'success'=> false,
                                    'message'=>'You are not subscribed to this program',
                                    'data'=> $search ], 200);                        
                    }
                else
                    {
                        $check = "Subscribed";
                    }
        
                $Agentfile=tb_program_files::select('Program_Name','Sentfrom','AssignmentName','File_Loc')
                                                ->where('Program_Name',$data)
                                                ->where('UserType','<>','Participant')
                                                ->get();

                $userfile=tb_program_files::select('Program_Name','UpdatedAgent','AssignmentName','usergrade','agentcomments','File_Loc')
                                                ->where('Program_Name',$data)
                                                ->where('UserID',$userId)
                                                ->get();
                        
             //   $collection = collect($user);
              //  $merged     = $collection->merge($user2);
              //  $result   = $merged->all();
                        
                $search['UserProgramStatus'] = $check;
                $search['MyFiles'] = $userfile;
                $search['Assignments'] = $Agentfile;
                                               
                return response()->json([
                                    'success'=> true,
                                    'data'=>$search],200);

            }
            else
            {
                $Agentfile=tb_program_files::select('Program_Name','Sentfrom','AssignmentName','File_Loc')
                ->where('Program_Name',$data)
                ->where('UserType','<>','Participant')
                ->get();

                $Participantfile=tb_program_files::select('Program_Name','Sentfrom','AssignmentName','usergrade','agentcomments','File_Loc')
                ->where('Program_Name',$data)
                ->where('UserType','Participant')
                ->get();

                $search['Assignments'] = $Agentfile;
                $search['ParticipantFiles'] = $Participantfile;
                       
                return response()->json([
                                    'success'=> true,
                                    'data'=>$search],200);


            }
        
    }

    public function deleteFile(Request $request)
    {
        $FileName= $request->json()->get('AssignmentName');

        $programName = $request->json()->get('Program_Name');

        $userID = $request->get('userID');

        $usertype =  User::select('roleType')
        ->where('IRFuserId',$userID)
        ->pluck('roleType');

        if('Participant' == $usertype)
        {
            $document = DB::table('tb_program_files')->select('File_Loc')
                                            ->where('AssignmentName', $FileName)
                                            ->where('Program_Name', $programName)
                                            -where('UserID',$userID)
                                            ->get();
            if(empty($document))
            {
                return response()->json(['success' => false, 'message' => 'Document not found'], 404);
            }
          
            //We remove existing document
            if(!empty($document))
            {
                Storage::disk('s3')->delete($document);
         
                DB::table('tb_program_files')->where('FileName', $FileName)
                                              ->delete();
              
                return response()->json(['success' => true, 'message' => 'Document deleted', 'data'=> $document], 200);
              
            }
        }
        else
        {
            $document = DB::table('tb_program_files')->select('File_Loc')
                    ->where('FileName', $FileName)
                    ->where('Program_Name', $programName)
                    ->get();

            if(empty($document))
            {
                return response()->json(['success' => false, 'message' => 'Document not found'], 404);
            }


            //We remove existing document
        if(!empty($document))
            {
                Storage::disk('s3')->delete($document);

                DB::table('tb_program_files')->where('FileName', $FileName)
                                                        ->delete();

                return response()->json(['success' => true, 'message' => 'Document deleted', 'data'=> $document], 200);

            }
        }

        return response()->json(['success' => false, 'message' => 'Unable to delete the document. Please try again later.'], 200);
    }

    public function showprograms(Request $request)
    {
        $result2['Category'] = DB::table('tb_community_programs')
            ->distinct('tb_community_programs.category')
            ->pluck('tb_community_programs.category')
            ->toarray();       

        foreach($result2['Category'] as $key => $title)
        {
            // $i= 0;
            $result[$title] = DB::table('tb_community_programs')
                                    ->select('tb_community_programs.programName') 
                                    ->where('tb_community_programs.category','=',$title)
                                    ->pluck('tb_community_programs.programName');
            //  $i = $i+1;
        }   
        return response()->json(['success' => true, 'data'=> $result], 200);
    }

    public function getUsertype(Request $request)
    {
        $userID = $request->get('userID');

        $usertype =  User::select('roleType')
                    ->where('IRFuserId',$userID)
                    ->pluck('roleType');
        return response()->json(['success' => true, 'data'=> $userID], 200);

    }
    public function showuserprograms(Request $request)
    {
       $userId = $request->get('userId');

       $result2['Programs'] = DB::table('tb_init_user_program_details')

       ->select('tb_init_user_program_details.programName')

       ->where('userId','=',$userId)

       ->pluck('tb_init_user_program_details.programName')

       ->toarray();           

       return response( $result2);
    }

    public function GetUsersforPrograms(Request $request)
    {
        $programname = $request->get('ProgramName');              

        $result = DB::table('tb_init_user_details')

                ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 

                ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell') 

                ->where('tb_init_user_program_details.programName',$programname)

                ->groupBy('tb_init_user_details.userId')

                ->get();  

            $search['programUsers'] = $result;

        return response()->json(['success' => true, 'data'=> $search], 200);
    }

    
    public function irfprogramlist(Request $request)

    {

 

        $result2['Category'] = DB::table('tb_community_programs')

        ->distinct('tb_community_programs.category')

        ->pluck('tb_community_programs.category')

        ->toarray();       

 

        foreach($result2['Category'] as $key => $title)

            {      

                $result[$title] = DB::table('tb_community_programs')

                                ->select('tb_community_programs.programName') 

                                ->where('tb_community_programs.category','=',$title)

                                ->pluck('tb_community_programs.programName');

            } 

            foreach($result as $key => $title)

               {

                    $a=null;

                    $temp1=null;

                    $temp=null;

                   // $currentItem[$title] = array();

                    foreach($title as $key2 => $val)

                        {

                            $temp1 = str_replace(' ', '', $val);

                            $temp2 = str_replace(' ', '', $key);

                            $temp = $temp2.$temp1;

                            $a[$temp] = ['isChecked' => false , 'value' => $val];                                  

                        }

                       $programs[$key]= (array) $a;

                }

            return response()->json(['success' => true, 'Programs'=> $programs], 200);

        }
}