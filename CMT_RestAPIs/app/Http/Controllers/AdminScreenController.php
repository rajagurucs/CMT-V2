<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;

// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;
// use DB;
use App\Models\tb_community_programs;

class AdminScreenController extends Controller
{
    //
    public function admin_addProgram(Request $request)
    {
        // $validator = Validator::make($request->json()->all() , [
        //     'CategoryName' => 'required|string|max:255',
        //     'ProgramName' => 'required|string|max:255',          
        // ]);

        // if($validator->fails())
        //     {
        //         return response()->json($validator->errors()->toJson(), 400);
        //     } 

        // $user = tb_community_programs::create([
        //     'category' => $request->json()->get('CategoryName'),
        //     'programName' => $request->json()->get('ProgramName'),
        //     // 'userId' => $request->json()->get('userId')            
        // ]);
         
        //     return response()->json(['success'=> True,'message'=> 'Program Added']);

        $program = tb_community_programs::create($request->all());

        return response()->json($program, 201);
    }

    public function show_allprogram()
    {
        return tb_community_programs::all();
    }

    public function delete_program(Request $request, $ProgramName)
    {
        $program = tb_community_programs::findOrFail($ProgramName);
        $program->delete();
        
        return response()->json(['success'=> true,'message'=> 'program Deleted']);
    }
}
