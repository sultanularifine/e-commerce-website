<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
     public function index()
    {
        $contactPage = ContactPage::first(); // we only have one contact page
        return view('backend.contact_page.index', compact('contactPage'));
    }

    public function edit($id)
    {
        $contactPage = ContactPage::findOrFail($id);
        return view('backend.contact_page.edit', compact('contactPage'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|string|max:100',
            'map_iframe' => 'nullable|string',
        ]);

        $contactPage = ContactPage::findOrFail($id);
        $contactPage->update($data);

        return redirect()->route('contact-page.index')->with('success', 'Contact page updated successfully!');
    }
}
