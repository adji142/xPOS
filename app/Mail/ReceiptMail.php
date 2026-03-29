<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $header;
    public $details;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header, $details, $company)
    {
        $this->header = $header;
        $this->details = $details;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Struk Pembayaran - " . $this->header->NoTransaksi)
                    ->view('Emails.receipt');
    }
}
