<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $data;
    public $Subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$Subject)
    {
        $this->data = $data;
        $this->Subject = $Subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject($this->Subject)
                    ->view('emails.emailkonfirmasi') // View for the email content
                    ->with('data', $this->data);
    }
}
