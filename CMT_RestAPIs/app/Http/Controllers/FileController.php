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
            'FileName' => 'required',
            'userID' => 'required',
        ]);

        $programName = $request->get('Program_Name');

        $data= $request->get('FileName');

        $userID= $request->get('userID');

        $checkfilename = tb_program_files::select('File_Loc')
                                            ->where('Program_Name',$programName)
                                            ->where('FileName',$data)
                                            ->first();   
                                            
        $usertype =  User::select('roleType')
                                            ->where('IRFuserId',$userID)
                                            ->value('roleType');

        if(is_null($checkfilename)) 
        {
            $base_location = 'user_documents';

            // Handle File Upload
            if($request->hasFile('document'))         
            {               
                $check = tb_init_user_program_details::select('program_details_id')
                ->where('programName',$programName)
                ->where('userId',$userID)
                ->first();

                if(is_null($check)) 
                {
                return response()->json(['success' => false, 'message' => 'Please Subcribe to the program first '.$userID], 400);
                }
                else
                {   
                $documentPath = $request->file('document')->store($base_location, 's3');

                $docpath1 = "https://cmtassignmentfiles.s3.ap-south-1.amazonaws.com/";

                $docpath = $docpath1.$documentPath;
    
                $filedetails = tb_program_files::create([
                    'Program_Name' => $request->get('Program_Name'),
                    'Sentfrom' => $userID,
                    'FileName' => $request->get('FileName'),
                    'UserType' => $usertype,
                    'File_Loc' => $docpath,
                ]);
    
                return response()->json(['success' => true, 'message' => 'Document successfully uploaded', 'document' => $filedetails], 200);
                }
    
            } 
            else 
            {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
            }    
      
        }
        else
        {
            return response()->json(['success' => false, 'message' => 'FileName already exist for the Program. Please upload with a different name'], 400);            
        }       
      
    }

    public function addgrade(Request $request)
    {

        $programName = $request->json()->get('Program_Name');

        $userID = $request->json()->get('userID');

        $FileName = $request->json()->get('FileName');

        $search_userprogram = tb_program_files::select('File_Loc')
                                            ->where('Program_Name',$programName)
                                            ->where('Sentfrom',$userID)
                                            ->where('FileName',$FileName)
                                            ->first();
       
        //Checking whether the User Query returns value             
        if(is_null($search_userprogram)) 
        {
              return response()->json([
                                      'success'=> false,
                                      'message'=>'User with a particular program does not upload any file'
                                        ],400);
        }  
        else
        {
            $user=tb_program_files::where('Program_Name',$programName)
                                    ->where('Sentfrom',$userID)
                                    ->where('FileName',$FileName)
                                    ->update([
                                            'usergrade' => $request->json()->get('usergrade'),
                                            'agentcomments' => $request->json()->get('agentcomments'),
                                            'Sentfrom' => $userID,
                                            'Program_Name' => $programName
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
                                    ]);
        }
                                    
        else
        {
                                                  
            return response()->json([
                                    'success'=> false,
                                    'message'=>'User already subscribed to the program: ' .$data 
                                    ]); 
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
                                    ]); 
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
                                    ]);
        }       

            return response()->json([
                                    'success'=> true,
                                    'message'=>'UnSubcribed to the Program',
                                    ]);

    }

    public function displayfiles(Request $request)
    {
        $data = $request->get('Program_Name');

        $userID = $request->get('userID');

        $check = tb_init_user_program_details::select('program_details_id')
                                                ->where('userId',$userID)
                                                ->where('programName',$data)
                                                ->first();
        
        if(is_null($check))
        {
            $check = "UnSubscribed";

            $search['UserProgramStatus'] = $check;
            $search['FileDetails'] = NULL;
                                    
            return response()->json([
                                    'success'=> false,
                                    'message'=>'You are not subscribed to this program',
                                    'data'=> $search ]);
                                            
        }
        else
        {
            $check = "Subscribed";
        }

        $search_userprogram = tb_program_files::select('File_Loc')->where('Program_Name',$data)
                                        ->first();                                
       
          //Checking whether the User Query returns value             
        if(is_null($search_userprogram)) 
        {           
            $search['UserProgramStatus'] = $check;
            $search['FileDetails'] = $data;

            return response()->json([
                                    'success'=> false,
                                    'message'=>'No Files Exist',
                                    'data'=> $search ]);
        } 
        else
        {
            $usertype =  User::select('roleType')
                                ->where('IRFuserId',$userID)
                                ->pluck('roleType');

            if('Participant' == $usertype)

            {
                $user=tb_program_files::select('Program_Name','Sentfrom','FileName','File_Loc','usergrade','agentcomments')
                                                ->where('Program_Name',$data)
                                                ->where('UserType','<>','Participant')
                                                ->get();

                $user2=tb_program_files::select('Program_Name','Sentfrom','FileName','File_Loc','usergrade','agentcomments')
                                                ->where('Program_Name',$data)
                                                ->where('Sentfrom','=',$userID)
                                                ->get();
                        
                $collection = collect($user);
                $merged     = $collection->merge($user2);
                $result   = $merged->all();
                        
                $search['UserProgramStatus'] = $check;
                $search['FileDetails'] = $result;
                                               
                return response()->json([
                                    'success'=> true,
                                    'data'=>$search],200);

            }
            else
            {
                $user=tb_program_files::select('Program_Name','Sentfrom','FileName','File_Loc','usergrade','agentcomments')
                                                ->where('Program_Name',$data)                        
                                                ->get();


                $search['UserProgramStatus'] = $check;
                $search['FileDetails'] = $user;
                       
                return response()->json([
                                    'success'=> true,
                                    'data'=>$search],200);


            }
        }
    }

    public function deleteFile(Request $request)
    {
        $FileName= $request->json()->get('FileName');

        $programName = $request->json()->get('Program_Name');

        $userID = $request->get('userID');

        $usertype =  User::select('roleType')
        ->where('IRFuserId',$userID)
        ->pluck('roleType');

        if('Participant' == $usertype)
        {
            $document = DB::table('tb_program_files')->select('File_Loc')
                                            ->where('FileName', $FileName)
                                            ->where('Program_Name', $programName)
                                            -where('sentfrom',$userID)
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

        return response()->json(['success' => false, 'message' => 'Unable to delete the document. Please try again later.'], 400);
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
}