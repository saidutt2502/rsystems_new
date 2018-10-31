<?php 

namespace App\Http\Traits;

use Session;
use DB;

use App\Mail\ApprovalMails;

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

        //Finding if the person is HoD of The department belonging to the Costcenter
            //Getting the department of the Costcenter
            $dept_id = DB::table('rs_costcenters')->where('id', $costcenter)
            ->value('department');

        //Getting the HoD of the Department
            $hod_id = DB::table('rs_departments')->where('id',$dept_id)
                        ->value('hod_id');
        

        if(session('user_id') == $hod_id){
            //If the HoD requests items in his own costcenter then it should directly go to the Admin

             //Updating in the approvals tables
             $approval_id = DB::table('rs_approvals')->insertGetId([
                'user_id' => session('user_id'), 
                'module_id' =>session('module_id'),
                'src_table'=> $src_table,
                'src_id'=> $insert_id,
                'status'=> '2',
                'remarks' => 'currently requested'
                ]);  

                //Updating in the parent table
                DB::table($src_table)
                            ->where('id', $insert_id)
                            ->update([
                                'status' => 5,
                            ]);

        }else{
                $higer_up_person = DB::table('rs_reporting')
                    ->where('reportee',session('user_id'))
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
                        }else{
                            //Send to approval to the HoD of Department
                            $approval_id = DB::table('rs_approvals')->insertGetId([
                            'user_id' => $hod_id, 
                            'module_id' =>session('module_id'),
                            'src_table'=> $src_table,
                            'src_id'=> $insert_id,
                            'remarks' => 'currently requested'
                            ]);  
                            
                        }

            //Send request to the HoD of that department          
            }else{
                $approval_id = DB::table('rs_approvals')->insertGetId([
                    'user_id' => $hod_id, 
                    'module_id' =>session('module_id'),
                    'src_table'=> $src_table,
                    'src_id'=> $insert_id,
                    'remarks' => 'currently requested'
                ]);  
            }
        }

         /*---------- Send email for approval  -  logic here------------- */
                $approver_id = DB::table('rs_approvals')->where('id', $approval_id )->value('user_id');
                $approver_email = DB::table('users')->where('id', $approver_id )->value('email');

                $count = $unapproved_requests = DB::table('rs_approvals')
                ->where('user_id',$approver_id)
                ->where('status','1')
                ->count();

                $mailData = array(
                    'count'     => $count,
                );

                \Mail::to($approver_email)->queue(new ApprovalMails($mailData));
         /*---------- Send email for approval - Ends ------------- */
    }

    public function get_higher_up1 ($insert_id,$src_table)
    {
        /*---------- Finding who to assign to approve -  logic here------------- */

        $higer_up_person = DB::table('rs_reporting')
                    ->where('reportee',session('user_id'))
                    ->first();

        //If higher up found in the rs_reporting table
            if($higer_up_person){
                    
                            //Send to approval to the Higher up person
                            $approval_id = DB::table('rs_approvals')->insertGetId([
                                'user_id' => $higer_up_person->reporter, 
                                'module_id' =>session('module_id'),
                                'src_table'=> $src_table,
                                'src_id'=> $insert_id,
                                'remarks' => 'currently requested'
                            ]);  
                            
                            
         /*---------- Send email for approval  -  logic here------------- */
                $approver_id = DB::table('rs_approvals')->where('id', $approval_id )->value('user_id');
                $approver_email = DB::table('users')->where('id', $approver_id )->value('email');

                $count = $unapproved_requests = DB::table('rs_approvals')
                ->where('user_id',$approver_id)
                ->where('status','1')
                ->count();
                
                $mailData = array(
                    'count'     => $count,
                );

                \Mail::to($approver_email)->queue(new ApprovalMails($mailData));
         /*---------- Send email for approval - Ends ------------- */
                        
          
            }
        }
    }

