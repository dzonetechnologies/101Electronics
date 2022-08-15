<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    var $data = [];
    var $SubjectLine;

    public function __construct($data, $Subject = '')
    {
        $this->data = $data;
        if($Subject != "") {
            $this->SubjectLine = $Subject;
        } else {
            $this->SubjectLine = "Thanks For Your Order at 101 Electronics";
        }
    }

    public function build()
    {
        $_data = $this->data;
        $this->subject($this->SubjectLine);
        return $this->view('email.order',compact('_data'));
    }
}