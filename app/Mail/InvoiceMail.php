<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfContent;
    public $tipeTransaksi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pdfContent, $tipeTransaksi)
    {
        $this->data = $data;
        $this->pdfContent = $pdfContent;
        $this->tipeTransaksi = $tipeTransaksi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        switch ($this->tipeTransaksi) {
            case 'OrderPenjualan':
                return $this->view('emails.documentinvice')
                    ->subject('Order Penjualan')
                    ->attachData($this->pdfContent, 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
            case 'Pembelian':
                return $this->view('emails.invoice')
                    ->subject('Invoice Pembelian')
                    ->attachData($this->pdfContent, 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
            default:
                return $this;
        }
    }
}
