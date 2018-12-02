<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminPasswordReset extends Mailable implements ShouldQueue
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
         $subject = 'Admin | Reset Password';
          
           // Array for Blade
                $input = array(
                                  'randomStr' => $this->mailData['randomStr'],
                                  'url' => $this->mailData['url'],
                              );
                              
         
        return $this->view('emails.adminReset')
                ->subject($subject)->withInputs($input);
    }
}
