<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectLine, $messageBody)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject($this->subjectLine)
                    ->view('emails.blast')
                    ->with([
                        'messageBody' => $this->messageBody,
                    ]);
    }
}
