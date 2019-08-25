<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

const DEFAULT_RECEIVE_MAIL_NAME = "Administrator";
const DEFAULT_RECEIVE_MAIL = "nonename1k@gmail.com";
const DEFAULT_RECEIVE_FROM = "nonename1k@gmail.com";
const DEFAULT_RECEIVE_FROM_NAME = "User Tester";
const DEFAULT_SUBJECT = "New Product";
class MailController extends Controller
{
    /**
     * send mail function
     *
     * @return void
     */
    public function index(
        $to_name = DEFAULT_RECEIVE_MAIL_NAME,
        $to_mail = DEFAULT_RECEIVE_MAIL,
        $from_name = DEFAULT_RECEIVE_FROM_NAME,
        $from_mail = DEFAULT_RECEIVE_FROM,
        $subject = DEFAULT_SUBJECT,
        $data = []
    ) {
        Mail::send('email.mail', $data, function ($obj) use ($to_name, $to_mail, $from_name, $from_mail, $subject) {
            $obj->to(session('email_session') ?? $to_mail, $to_name)->subject($subject);
            $obj->from($from_mail, $from_name);
        });

        redirect('/home');
    }

    public function setSession(Request $request)
    {
        $request->session()->put('email_session', $request->email);
        if ($request->session()->exists('email_session')) {
            return response()->json(['success'=> 'Verification will be send to' .session('email_session')]);
        }
    }
}
