<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use Illuminate\Http\Request;

class AboutInfoController extends Controller
{
    public function index()
    {
        $about = AboutInfo::first();
        return view('backend.about.index', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutInfo::findOrFail($id);

        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'who_we_are' => 'nullable|string',
            'our_story' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('about', 'public');
            $data['image'] = $path;
        }

        $about->update($data);

        return back()->with('success', 'About info updated successfully');
    }
}
