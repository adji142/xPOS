<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EMenuOrderMail extends Mailable implements ShouldQueue
{
    use Queueable;

    public $orderHeader;
    public $orderItems;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderHeader, $orderItems, $company)
    {
        $this->orderHeader = $orderHeader;
        $this->orderItems = $orderItems;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.emenu_order')
                    ->subject('Konfirmasi Pesanan - ' . ($this->company->NamaPartner ?? 'E-Menu'))
                    ->with([
                        'orderHeader' => $this->orderHeader,
                        'orderItems' => $this->orderItems,
                        'company' => $this->company
                    ]);
    }
}
