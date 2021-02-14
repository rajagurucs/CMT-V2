<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\tb_init_user_details;
use App\Models\tb_child_details;
use App\Models\tb_init_user_program_details;
use App\Models\tb_init_user_extra_details;
use App\Models\tb_init_user_goals;
use App\Models\tb_init_user_health_details;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function programReport(Request $request)
    {

     
         if ($request->has('category'))
                {  
                    $catname= $request->get('category');  
                  
                    if ($request->has('programName')) 
                        {

                            $programname = $request->get('programName');

                            if ($request->has('zipCode')) 
                                {
                                      $zipcode = $request->get('zipCode');        
                  
                                      $result = DB::table('tb_init_user_details')
                                              ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                              ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                              ->where('tb_init_user_program_details.category', $catname)
                                              ->where('tb_init_user_program_details.programName',$programname)
                                              ->where('tb_init_user_details.zipCode',$zipcode)
                                              ->groupBy('tb_init_user_details.userId')
                                              ->get(); 
  
                                  $search['programreport'] = $result;
  
                                //   return response($search,200);

                                  return response()->json(['success'=> true,'data'=>$search]);

                            }

                          else
                            {

                              $result = DB::table('tb_init_user_details')
                              ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                              ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                              ->where('tb_init_user_program_details.category', $catname)
                              ->where('tb_init_user_program_details.programName',$programname)
                              ->groupBy('tb_init_user_details.userId')
                              ->get(); 

                               $search['programreport'] = $result;

                            //   return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);


                            }
                        }

                        else if ($request->has('zipCode')) 
                        {
                              $zipcode = $request->get('zipCode');        
          
                              $result = DB::table('tb_init_user_details')
                                      ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                      ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                      ->where('tb_init_user_program_details.category', $catname)
                                      ->where('tb_init_user_details.zipCode',$zipcode)
                                      ->groupBy('tb_init_user_details.userId')
                                      ->get(); 

                          $search['programreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                         }
                            $catname= $request->get('category');        
                  
                            $result = DB::table('tb_init_user_details')
                                        ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                        ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                        ->where('tb_init_user_program_details.category', $catname)
                                        ->groupBy('tb_init_user_details.userId')
                                        ->get(); 

                            $search['programreport'] = $result;

                            // return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);

                }
         else if ($request->has('programName'))
                {

                  $programname = $request->get('programName');

                  if($request->has('zipCode'))

                      {

                        $zipcode = $request->get('zipCode');                          

                        $result = DB::table('tb_init_user_details')
                                  ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                  ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                  ->where('tb_init_user_program_details.programName',$programname)
                                  ->where('tb_init_user_details.zipCode', $zipcode)
                                  ->groupBy('tb_init_user_details.userId')
                                  ->get(); 

                         $search['programreport'] = $result;

                        //  return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                      }

                        
                          $result = DB::table('tb_init_user_details')
                                        ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                        ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                        ->where('tb_init_user_program_details.programName', $programname)
                                        ->groupBy('tb_init_user_details.userId')
                                        ->get(); 

                          $search['programreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                }

         else if ($request->has('zipCode'))
                {
                           
                                $zipcode = $request->get('zipCode');

                                $result = DB::table('tb_init_user_details')
                                          ->join('tb_init_user_program_details','tb_init_user_details.userId','=','tb_init_user_program_details.userId') 
                                          ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode',DB::raw('group_concat(tb_init_user_program_details.programName) AS programName'),'tb_init_user_program_details.category') 
                                          ->where('tb_init_user_details.zipCode', $zipcode)
                                          ->groupBy('tb_init_user_details.userId')
                                          ->get(); 

                                $search['programreport'] = $result;

                                // return response($search,200);
                                return response()->json(['success'=> true,'data'=>$search]);

                }
               
                
    }

    public function goalReport(Request $request)
    {

     
         if ($request->has('category'))
                {  
                    $catname= $request->get('category');  
                  
                    if ($request->has('programName')) 
                        {

                            $programname = $request->get('programName');

                            if ($request->has('zipCode')) 
                                {
                                      $zipcode = $request->get('zipCode');        
                  
                                      $result = DB::table('tb_init_user_details')
                                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                              ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                                              ->where('tb_init_user_goals.user_goal_program_name', $programname)
                                              ->where('tb_init_user_details.zipCode',$zipcode)
                                              ->groupBy('tb_init_user_details.userId')
                                              ->get(); 
  
                                  $search['goalreport'] = $result;
  
                                //   return response($search,200);
                                return response()->json(['success'=> true,'data'=>$search]);

                            }

                          else
                            {

                              $result = DB::table('tb_init_user_details')
                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                              ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                              ->where('tb_init_user_goals.user_goal_program_name',$programname)
                              ->groupBy('tb_init_user_details.userId')
                              ->get(); 

                               $search['goalreport'] = $result;

                            //   return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);


                            }
                        }

                        else if ($request->has('zipCode')) 
                        {
                              $zipcode = $request->get('zipCode');        
          
                              $result = DB::table('tb_init_user_details')
                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                              ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                              ->where('tb_init_user_details.zipCode',$zipcode)
                              ->groupBy('tb_init_user_details.userId')
                              ->get();  

                          $search['goalreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                         }
                            $catname= $request->get('category');        
                  
                            $result = DB::table('tb_init_user_details')
                            ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                            ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                            ->where('tb_init_user_goals.user_goal_category_name', $catname)
                            ->groupBy('tb_init_user_details.userId')
                            ->get(); 

                            $search['goalreport'] = $result;

                            // return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);

                }
         else if ($request->has('programName'))
                {

                  $programname = $request->get('programName');

                  if($request->has('zipCode'))

                      {

                        $zipcode = $request->get('zipCode');                          

                        $result = DB::table('tb_init_user_details')
                                  ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                  ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                                  ->where('tb_init_user_goals.user_goal_program_name',$programname)
                                  ->where('tb_init_user_details.zipCode',$zipcode)
                                  ->groupBy('tb_init_user_details.userId')
                                  ->get(); 

                         $search['goalreport'] = $result;

                        //  return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                      }

                        
                      $result = DB::table('tb_init_user_details')
                      ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                      ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                      ->where('tb_init_user_goals.user_goal_program_name',$programname)
                      ->groupBy('tb_init_user_details.userId')
                      ->get(); 

                          $search['goalreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                }

         else if ($request->has('zipCode'))
                {
                           
                                $zipcode = $request->get('zipCode');

                                $result = DB::table('tb_init_user_details')
                                ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                ->select('tb_init_user_details.userId','tb_init_user_details.firstName','tb_init_user_details.lastName','tb_init_user_details.email','tb_init_user_details.phoneCell','tb_init_user_details.zipCode','tb_init_user_goals.user_goal_category_name','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_RatingBefore','tb_init_user_goals.user_goal_program_RatingAfter') 
                                ->where('tb_init_user_details.zipCode',$zipcode)
                                ->groupBy('tb_init_user_details.userId')
                                ->get();  

                                $search['goalreport'] = $result;

                                // return response($search,200);
                                return response()->json(['success'=> true,'data'=>$search]);

                }
               
                
    }

    public function notesReport(Request $request)
    {

     
         if ($request->has('category'))
                {  
                    $catname= $request->get('category');  
                  
                    if ($request->has('programName')) 
                        {

                            $programname = $request->get('programName');

                            if ($request->has('zipCode')) 
                                {
                                      $zipcode = $request->get('zipCode');        
                  
                                      $result = DB::table('tb_init_user_details')
                                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                              ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                                              ->where('tb_init_user_goals.user_goal_program_name',$programname)
                                              ->where('tb_init_user_details.zipCode',$zipcode)
                                              ->groupBy('tb_init_user_details.userId')
                                              ->get(); 
  
                                  $search['notesreport'] = $result;
  
                                //   return response($search,200);
                                return response()->json(['success'=> true,'data'=>$search]);

                            }

                          else
                            {

                              $result = DB::table('tb_init_user_details')
                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                              ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                              ->where('tb_init_user_goals.user_goal_program_name',$programname)
                              ->groupBy('tb_init_user_details.userId')
                              ->get(); 

                               $search['notesreport'] = $result;

                            //   return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);


                            }
                        }

                        else if ($request->has('zipCode')) 
                        {
                              $zipcode = $request->get('zipCode');        
          
                              $result = DB::table('tb_init_user_details')
                              ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                              ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                              ->where('tb_init_user_goals.user_goal_category_name', $catname)
                              ->where('tb_init_user_details.zipCode',$zipcode)
                              ->groupBy('tb_init_user_details.userId')
                              ->get();  

                          $search['notesreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                         }
                            $catname= $request->get('category');        
                  
                            $result = DB::table('tb_init_user_details')
                            ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                            ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                            ->where('tb_init_user_goals.user_goal_category_name', $catname)
                            ->groupBy('tb_init_user_details.userId')
                            ->get(); 

                            $search['notesreport'] = $result;

                            // return response($search,200);
                            return response()->json(['success'=> true,'data'=>$search]);

                }
         else if ($request->has('programName'))
                {

                  $programname = $request->get('programName');

                  if($request->has('zipCode'))

                      {

                        $zipcode = $request->get('zipCode');                          

                        $result = DB::table('tb_init_user_details')
                                  ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                  ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                                  ->where('tb_init_user_goals.user_goal_program_name',$programname)
                                  ->where('tb_init_user_details.zipCode',$zipcode)
                                  ->groupBy('tb_init_user_details.userId')
                                  ->get(); 

                         $search['notesreport'] = $result;

                        //  return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                      }

                        
                      $result = DB::table('tb_init_user_details')
                      ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                      ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                      ->where('tb_init_user_goals.user_goal_program_name',$programname)
                      ->groupBy('tb_init_user_details.userId')
                      ->get(); 

                          $search['notesreport'] = $result;

                        //   return response($search,200);
                        return response()->json(['success'=> true,'data'=>$search]);

                }

         else if ($request->has('zipCode'))
                {
                           
                                $zipcode = $request->get('zipCode');

                                $result = DB::table('tb_init_user_details')
                                ->join('tb_init_user_goals','tb_init_user_details.userId','=','tb_init_user_goals.userId') 
                                ->select('tb_init_user_details.userId','tb_init_user_goals.user_goal_program_name','tb_init_user_goals.user_goal_program_status','tb_init_user_goals.user_goal_program_participantcomments','tb_init_user_goals.user_goal_program_additionalcomments','tb_init_user_details.notes') 
                                ->where('tb_init_user_details.zipCode',$zipcode)
                                ->groupBy('tb_init_user_details.userId')
                                ->get();  

                                $search['notesreport'] = $result;

                                // return response($search,200);
                                return response()->json(['success'=> true,'data'=>$search]);

                }
               
                
    }  


}
