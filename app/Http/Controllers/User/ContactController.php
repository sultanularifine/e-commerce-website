<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {

        $contactPage = ContactPage::first();

        return view('frontend.pages.contact', compact('contactPage'));
    }
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        // Save to database
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $request->phone ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new', // default status
        ]);

        // Send email
        Mail::raw(
            "You have received a new message from the contact form:\n\n" .
                "Name: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Phone: " . ($validated['phone'] ?? '-') . "\n" .
                "Subject: {$validated['subject']}\n" .
                "Message: {$validated['message']}\n",
            function ($mail) use ($validated) {
                $mail->to('support@autopartsmarket.com')
                    ->subject($validated['subject'])
                    ->from($validated['email'], $validated['name']);
            }
        );

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
