<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\tb_community_programs;
use App\Models\User;

class AdminScreenController extends Controller
{
    //
    public function admin_addProgram(Request $request)
    {
        $validator = Validator::make($request->json()->all() , [
            'category' => 'required|string|max:255',
            'programName' => 'required|string|max:255|unique:tb_community_programs',          
        ]);

        if($validator->fails())
            {
                return response()->json($validator->errors()->toJson(), 400);
            } 

        $cmtprogram = tb_community_programs::create([
            'category' => $request->json()->get('category'),
            'programName' => $request->json()->get('programName'),
            // 'userId' => $request->json()->get('userId')            
        ]);
         
            return response()->json(['success'=> True,'message'=> 'Program Added']);

        // $cmtprogram = tb_community_programs::create($request->all());

        // return response()->json($cmtprogram, 201);
    }

    public function show_allprogram()
    {
        // return tb_community_programs::all();
        $result2['Category'] = DB::table('tb_community_programs')
                            ->distinct('tb_community_programs.category')
                            ->pluck('tb_community_programs.category')
                            ->toarray();     

            foreach($result2['Category'] as $key => $title)
            {
            $result[$title] = DB::table('tb_community_programs')
                ->select('tb_community_programs.programName') 
                ->where('tb_community_programs.category','=',$title)
                // ->groupBy('tb_community_programs.programName')
                ->get();
            }
            
            // return response( $result);
            return response()->json(['success'=> true,'data'=> $result]);
    }

    public function show_allcategory()
    {
        return tb_community_programs::category();
    }

    public function delete_program(Request $request)
    {
        // $cmtprogram = tb_community_programs::findOrFail($programName);
        // $cmtprogram->delete();
        $program= $request->json()->get('programName');
        
        $cmtprogram = tb_community_programs::where('programName', $program)
                                            ->delete();
        
        return response()->json(['success'=> true,'message'=> 'program Deleted']);
    }

    public function show_alluser()
    {
        // return tb_community_programs::all();
        $username['firstName'] = DB::table('users')
                            ->distinct('users.firstName')
                            ->pluck('users.firstName')
                            ->toarray();     

            foreach($username['firstName'] as $key => $title)
            {
            $result[$title] = DB::table('users')
                ->select('users.email') 
                ->where('users.firstName','=',$title)                
                // ->get();
                // need to change as below
                ->pluck('users.email')
                ->toarray(); 
            }
            
            // return response( $result);
            return response()->json(['success'=> true,'data'=> $result]);
    }

    public function delete_user(Request $request)
    {
        $username= $request->json()->get('firstName');
        $useremail= $request->json()->get('email');
        
        $cmtuser = User::where('email', $useremail)
                        ->where('firstName',$username)
                            ->delete();
        
        return response()->json(['success'=> true,'message'=> 'user Deleted']);
    }    

}
