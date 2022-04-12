<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $link;
    public $userName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        // print_r($details['link']);
        // exit();
        $this->link = $details['link'];
        $this->userName = $details['userName'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('Email confirmation from bookfly.com')
        //             ->view('provider.mail.userAddMail');
        return $this->subject('Email confirmation from bookfly.com')
                    ->view('provider.mail.userAddMail', ['link'=>$this->link, 'userName'=>$this->userName]);
    }
}
