<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function InitMail()
    {
        $details = [
            'title' => 'Mail from Laravel App',
            'body' => 'This is a test email.'
        ];

        Mail::to('prasetyoajiw@gmail.com')->send(new SendMail($details));

        return "Email sent successfully!";
    }
}
