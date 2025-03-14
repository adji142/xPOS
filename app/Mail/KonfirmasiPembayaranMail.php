<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPembayaranMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $emailPelanggan; // 🔹 Tambahkan email pelanggan

    public function __construct($booking, $emailPelanggan)
    {
        $this->booking = $booking;
        $this->emailPelanggan = $emailPelanggan; // 🔹 Simpan email pelanggan
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran Booking')
                    ->view('emails.konfirmasiPembayaran')
                    ->with([
                        'booking' => $this->booking,
                        'emailPelanggan' => $this->emailPelanggan, // 🔹 Kirim ke view
                    ]);
    }
}


