<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index($name, $to, $from, $subject, $title, $data)
    {
        $data = [];
        Mail::send('email.mail', $data, function ($message) use ($name, $to, $from, $subject, $title) {
            $message->to($to, $name)->subject($subject);
            $message->from($from, $title);
        });

        redirect('/home');
    }
}
