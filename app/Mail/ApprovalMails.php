<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalMails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   

    /**
     * Build the message.
     *
     * @return $this
     */
   public $mailData;
     
   public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }



    public function build()
    {
         $subject = 'Pending Approvals';
         
         
         // $input =  $this->mailData ;  
          
           // Array for Blade
                $input = array(
                                  'count' => $this->mailData['count'],
                              );
                              
         
        return $this->view('emails.approval')
                ->subject($subject)->withInputs($input);
    }
}
