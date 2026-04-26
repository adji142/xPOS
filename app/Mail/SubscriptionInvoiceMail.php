<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $invoice;

    public function __construct(array $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build(): static
    {
        $subject = $this->invoice['isSuspended']
            ? 'Akun Anda Ditangguhkan – Tagihan Perpanjangan Langganan'
            : 'Tagihan Perpanjangan Langganan – Jatuh Tempo dalam 7 Hari';

        return $this->view('emails.subscription_invoice')
            ->subject($subject);
    }
}
