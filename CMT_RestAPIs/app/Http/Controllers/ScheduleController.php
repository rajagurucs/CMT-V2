<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\tb_program_schedule;
use App\Models\User;
use DB;
class ScheduleController extends Controller
{
    //
    public function show_all()
    {
        return tb_program_schedule::all();
    }

    public function show($id)
    {
        return tb_program_schedule::find($id);
    }

    public function show_date($ToDate)
    {
        return tb_program_schedule::find($ToDate);
    }

    // public function show_date(Request $request)
    // {
    //     $date = $request->get('StartDate');

    //     // $search_bydate = tb_program_schedule::where('StartDate', 'like', "%{$date}%") 
    //     //                                     // ->orWhere('id', 'like', "%{$data}%")                        
    //     //                                     ->get();

    //     // return response()->json($search_bydate, 200);
    //     return tb_program_schedule::find($date);
    // }

    public function add_schedule(Request $request)
    {
        // $schedule = tb_program_schedule::create($request->all());

        // return response()->json($schedule, 201);       

        $validator = Validator::make($request->json()->all() , [
            'Category' => 'required|string|max:255',
            'ProgramName' => 'required|string|max:255',  
            'Description' => 'required|string|max:255',  
            'FromDate'=> 'required|date|date_format:m/d/Y H:i:s|after:5 hours',
            'ToDate'=> 'required|date|date_format:m/d/Y H:i:s|after:FromDate',
            'Recurrence'=> 'required|in:daily,weekly,monthly,none',
            'NoOfTimes'=>'required|integer|max:10', 
            // 'id'=> 'required|string|max:10|unique:users',         
        ]);

        if($validator->fails())
            {
                // return response()->json($validator->errors()->toJson(), 400);
                return response()->json(['success'=> false, 'error'=> $validator->messages()]);
            } 
            // $recurrence = $request->json()->get('Recurrence');

            switch($request->Recurrence) 
            {
                case('monthly'):
     
                    // $posts = Post::Create([
                    //     'name' => $request->name;
                    //     'description' => $request->description;
                    //     'status' => $request->status;
                    // ]);
     
                    // $msg = 'Post successfully saved.';

                    return response()->json(['success'=> True, 'data'=> 'monthly']);
     
                    break;
     
                case('weekly'):
                     
                    // $posts = Post::find($request->id)->first();
     
                    // $post->name = $request->name;
                    // $post->description = $request->description;
                    // $post->status = $request->status;
     
                    // $post->save();
     
                    // $msg = 'Post successfully updated.';

                    return response()->json(['success'=> True, 'data'=> 'weekly']);
     
                    break;
                    
                case('daily'):     
    
                    return response()->json(['success'=> True, 'data'=> 'daily']);
         
                    break;

                case('none'):                   

                    return response()->json(['success'=> True, 'data'=> 'No Recurrence']);
     
                    break;
     
                default:
                    // $schedule = tb_program_schedule::create([
                    // 'Category' => $request->json()->get('Category'),
                    // 'ProgramName' => $request->json()->get('ProgramName'),
                    // 'Description' => $request->json()->get('Description'),
                    // 'FromDate' => $request->json()->get('FromDate'),
                    // 'ToDate' => $request->json()->get('ToDate'),  
                    // 'UserID' => $request->json()->get('UserID'), 
                    // ]);
                 
                    // return response()->json($schedule, 201);

                    return response()->json(['success'=> True, 'data'=> 'Default']);
            }
     
    }

    public function update_schedule(Request $request, $id)
    {
        $schedule = tb_program_schedule::findOrFail($id);
        if($schedule == NULL)
        {
            return response()->json(['success'=>false,'message'=>'data does not exist']);
        }
        $schedule->update($request->all());

        //return $task;

        return response()->json($schedule, 200);
        
        return response()->json($schedule, 201);
       

        // $validator = Validator::make($request->json()->all() , [
        //     'Category' => 'required|string|max:255',
        //     'ProgramName' => 'required|string|max:255',  
        //     'Description' => 'required|string|max:255',  
        //     'FromDate'=> 'required|date|date_format:m/d/Y H:i:s|after:5 hours',
        //     'ToDate'=> 'required|date|date_format:m/d/Y H:i:s|after:FromDate',    
        //     // 'id'=> 'required|string|max:10|unique:users',         
        // ]);

        // if($validator->fails())
        //     {
        //         // return response()->json($validator->errors()->toJson(), 400);
        //         return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        //     } 

        // $schedule = tb_program_schedule::update([
        //     'Category' => $request->json()->get('Category'),
        //     'ProgramName' => $request->json()->get('ProgramName'),
        //     'Description' => $request->json()->get('Description'),
        //     'FromDate' => $request->json()->get('FromDate'),
        //     'ToDate' => $request->json()->get('ToDate'),  
        //     'UserID' => $request->json()->get('UserID'), 
        // ]);
         
        // return response()->json($schedule, 201);
        // return response()->json(['success'=> True, 'data'=> $schedule]);
    }

    public function delete_schedule(Request $request, $id)
    {
        $schedule = tb_program_schedule::findOrFail($id);
        $schedule->delete();
        
        return response()->json(['success'=> true,'message'=> 'Event Deleted']);
    }
}

