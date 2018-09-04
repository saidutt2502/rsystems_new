<?php 

namespace App\Http\Traits;

use Session;
use DB;

trait ApprovalTraits
{
    public function get_approval_notifications()
    {
        $unapproved_requests = DB::table('rs_approvals')
                                    ->where('user_id',session('user_id'))
                                    ->where('status','1')
                                    ->count();
        return $unapproved_requests;
    }

    public function get_higher_up($costcenter,$insert_id,$src_table)
    {
        /*---------- Finding who to assign to approve -  logic here------------- */

        $higer_up_person = DB::table('rs_reporting')
                    ->where('reportee',session('user_id'))
                    ->where('department',session('dept_id'))
                    ->first();

     //If higher up found in the rs_reporting table
        if($higer_up_person){
                //Check if the cost center is assigned to that person
                    $is_cc_assigned = DB::table('rs_cc2modules')
                        ->where('user', $higer_up_person->reporter)
                        ->where('costcenter', $costcenter)
                        ->exists();

                    if($is_cc_assigned){
                        //Send to approval to the Higher up person
                        $approval_id = DB::table('rs_approvals')->insertGetId([
                            'user_id' => $higer_up_person->reporter, 
                            'module_id' =>session('module_id'),
                            'src_table'=> $src_table,
                            'src_id'=> $insert_id,
                            'remarks' => 'currently requested'
                        ]);   
                    }else if($higer_up_person->level == '2'){
                        //this means that Costcenter was created by the HoD
                            $approval_id = DB::table('rs_approvals')->insertGetId([
                                'user_id' => $higer_up_person->reporter, 
                                'module_id' =>session('module_id'),
                                'src_table'=> $src_table,
                                'src_id'=> $insert_id,
                                'remarks' => 'currently requested'
                            ]);  
                    }

        //Send request to the HoD of that department          
        }else{

            //Getting the department of the Costcenter
                $dept_id = DB::table('rs_costcenters')->where('id', $costcenter)
                                                                ->value('department');
            //Getting the HoD of the Department
                $hod_id = DB::table('rs_departments')->where('id',$dept_id)
                                                                ->value('hod_id');

            $approval_id = DB::table('rs_approvals')->insertGetId([
                'user_id' => $hod_id, 
                'module_id' =>session('module_id'),
                'src_table'=> $src_table,
                'src_id'=> $insert_id,
                'remarks' => 'currently requested'
            ]);  

        }

    }

}