<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->data['title'] = 'تواصل جديد من خلال موقع اعتمد';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('front.email')
            ->subject($this->data['title'])
            ->with('data',$this->data);
    }
}
