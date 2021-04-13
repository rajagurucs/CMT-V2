<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\tb_program_schedule;

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

    public function show_date($StartDate)
    {
        return tb_program_schedule::find($StartDate);
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
        $schedule = tb_program_schedule::create($request->all());

        return response()->json($schedule, 201);
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
    }

    public function delete_schedule(Request $request, $id)
    {
        $schedule = tb_program_schedule::findOrFail($id);
        $schedule->delete();
        
        return response()->json(['success'=> true,'message'=> 'Event Deleted']);
    }
}

