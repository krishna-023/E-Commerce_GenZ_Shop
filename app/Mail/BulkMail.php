<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyMessage;

    public function __construct($subject, $message)
    {
        $this->subjectLine = $subject;
        $this->bodyMessage = $message;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('auth.emails.bulk')
                    ->with(['messageBody' => $this->bodyMessage]);
    }
}
