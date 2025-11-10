<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
   public function index()
    {
        $contacts = Contact::latest()->get();
        return view('backend.contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'read']); // mark as read
        return view('backend.contact.show', compact('contact'));
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('success', 'Message deleted successfully!');
    }
}
