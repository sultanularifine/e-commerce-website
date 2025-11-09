<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
     public function index()
    {
       
        return view('frontend.pages.contact');
    }
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        // Send email example
        Mail::raw($request->message, function($mail) use ($request) {
            $mail->to('support@autopartsmarket.com')
                 ->subject($request->subject)
                 ->from($request->email, $request->name);
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
