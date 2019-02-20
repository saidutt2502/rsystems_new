<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductionUpdated extends Mailable implements ShouldQueue
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
         $subject = 'Production List Updated';
                  
           // Array for Blade
                $input = array(
                                  'dept' => $this->mailData['dept'],
                                  'user' => $this->mailData['user'],
                              );
                              
         
        return $this->view('emails.productionUpdated')
                ->subject($subject)->withInputs($input);
    }
}
