<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index($to_name, $to_mail, $from, $subject, $title, $data)
    {
        $data = [];
        Mail::send('email.mail', $data, function ($message) use ($to_name, $to_mail, $from, $subject, $title) {
            $message->to($to_mail, $to_name)->subject($subject);
            $message->from($from, $title);
        });

        redirect('/home');
    }
}
