<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StationaryThreshold extends Mailable implements ShouldQueue
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
         $subject = 'Stationary Item below threshold';
                  
           // Array for Blade
                $input = array(
                                  'item_name' => $this->mailData['item_name'],
                              );
                              
         
        return $this->view('emails.stationaryThreshold')
                ->subject($subject)->withInputs($input);
    }
}
