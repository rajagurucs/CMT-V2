<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\tb_feeds;
use App\Models\User;

class FeedsController extends Controller
{
    //
    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'Title' => 'required',
    //         'Post' => 'required',
    //         'attachement' => 'required|mimes:pdf,png,jpg,jpeg,doc,docx,xls,xlsx|max:9999',            
    //         'userID' => 'required',
    //     ]);

    //     $post = $request->get('Post');

    //     $title= $request->get('Title');

    //     $userID= $request->get('userID');

    //     $checkTitle = tb_feeds::select('File_Loc')
    //                                         ->where('Post',$post)
    //                                         ->where('Title',$title)
    //                                         ->first();   
                                            
    //     $usertype =  User::select('roleType')
    //                                         ->where('IRFuserId',$userID)
    //                                         ->value('roleType');

    //     if(is_null($checkTitle)) 
    //     {
    //         $base_location = 'user_attachements';

    //         // Handle File Upload
    //         if($request->hasFile('attachement'))         
    //         {               
    //             $check = tb_init_user_program_details::select('program_details_id')
    //             ->where('programName',$post)
    //             ->where('userId',$userID)
    //             ->first();

    //             if(is_null($check)) 
    //             {
    //             return response()->json(['success' => false, 'message' => 'Please Subcribe to the program first '.$userID], 200);
    //             }
    //             else
    //             {   
    //             $attachementPath = $request->file('attachement')->store($base_location, 's3');

    //             $docpath1 = "https://cmtassignmentfiles.s3.ap-south-1.amazonaws.com/";

    //             $docpath = $docpath1.$attachementPath;
    
    //             $filedetails = tb_feeds::create([
    //                 'Post' => $request->get('Post'),
    //                 'Sentfrom' => $userID,
    //                 'Title' => $request->get('Title'),
    //                 'UserType' => $usertype,
    //                 'File_Loc' => $docpath,
    //             ]);
    
    //             return response()->json(['success' => true, 'message' => 'Attachement successfully uploaded', 'attachement' => $filedetails], 200);
    //             }
    
    //         } 
    //         else 
    //         {
    //         return response()->json(['success' => false, 'message' => 'No file uploaded'], 200);
    //         }    
      
    //     }
    //     else
    //     {
    //         return response()->json(['success' => false, 'message' => 'Title already exist for the Program. Please upload with a different name'], 200);            
    //     }       
      
    // }
    public function add_post(Request $request)
    {
        $validator = Validator::make($request->json()->all() , [
            'Title' => 'required|string|max:255',
            'PostContent' => 'required|string|max:255|',
            'userID' => 'required',          
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 

        $post = tb_feeds::create([
            'Title' => $request->json()->get('Title'),
            'PostContent' => $request->json()->get('PostContent'),
            'UserID' => $request->json()->get('userID')            
        ]);
         
            return response()->json(['success'=> True,'message'=> 'Post Added'], 200);
    }

    public function show_allpost()
    {
        // return tb_community_programs::all();
        $result['Title'] = DB::table('tb_feeds')
                            // ->distinct('tb_feeds.Title')
                            ->pluck('tb_feeds.Title')
                            ->toarray();     

            foreach($result['Title'] as $key => $title)
            {
            $result[$title] = DB::table('tb_feeds')
                ->select('tb_feeds.PostContent') 
                ->where('tb_feeds.Title','=',$title)               
                ->get();
            }
            
            // return response( $result);
            return response()->json(['success'=> true,'data'=> $result]);
    }
    public function show_alltitle()
    {
        return tb_feeds::Title();
    }
    public function delete_post(Request $request)
    {        
        $post= $request->json()->get('PostContent');
        
        $feedpost = tb_feeds::where('PostContent', $post)
                                            ->delete();
        
        return response()->json(['success'=> true,'message'=> 'Post Deleted']);
    }

    // public function update_post(Request $request)
    // {        
    //     $post= $request->json()->get('PostContent');
    //     $post= $request->json()->get('Title');
        
    //     $feedpost = tb_feeds::where('Post', $post)
    //                                         ->update();
        
    //     return response()->json(['success'=> true,'message'=> 'post Deleted']);
    // }

    public function update_post(Request $request, $id)
    {
        $post = tb_feeds::findOrFail($id);
        if($post == NULL)
        {
            return response()->json(['success'=>false,'message'=>'data does not exist']);
        }
        $post->update($request->all());

        //return $task;

        return response()->json($post, 200);
    }

    public function add_like(Request $request, $id)
    {
        $validator = Validator::make($request->json()->all(),
        [
            'email' => 'required|string|max:255', 
            'PostContent' => 'required|string|max:255|',           
            'Title' => 'required|string|max:255'       
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 
        
        $email= $request->json()->get('email');        
        $Title= $request->json()->get('Title');
        $PostContent= $request->json()->get('PostContent');
        

        $data= User::where('email', $email)
                                    // ->where('password',$password)
                                    ->first();
        if(!empty($data))
        {
            DB::table('users')->where('email', $email)
            // ->where('password',$password)
            ->update(['password' => Hash::make($request->json()->get('new_password'))]);
         
               return response()->json(['success'=> true,'message'=> 'Password changed']);
        }
    else
        {
             return response()->json(['success'=> false,'message'=> 'Invalid details.!please try again.']);
        }
    }
    public function add_dislike(Request $request, $id)
    {
        $post = tb_feeds::findOrFail($id);
        if($post == NULL)
        {
            return response()->json(['success'=>false,'message'=>'disliked']);
        }
        $post->update($request->all());

        //return $task;

        return response()->json($post, 200);
    }
}
