<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
public function index()
{
    $footers = FooterSetting::orderBy('order')->get();
    $logo = FooterSetting::where('type', 'logo')->first();
    return view('backend.footer.index', compact('footers', 'logo'));
}

    public function create()
    {
        return view('backend.footer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $footer = new FooterSetting($request->except('logo'));

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/footer'), $filename);
            $footer->logo = $filename;
        }

        $footer->save();

        return redirect()->route('footer.index')->with('success', 'Footer item added successfully.');
    }

    public function edit(FooterSetting $footer)
    {
        return view('backend.footer.edit', compact('footer'));
    }

    public function update(Request $request, FooterSetting $footer)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'value' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $footer->fill($request->except('logo'));

        if ($request->hasFile('logo')) {
            // delete old logo if exists
            if ($footer->logo && file_exists(public_path('uploads/footer/' . $footer->logo))) {
                unlink(public_path('uploads/footer/' . $footer->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/footer'), $filename);
            $footer->logo = $filename;
        }

        $footer->save();

        return redirect()->route('footer.index')->with('success', 'Footer updated successfully.');
    }

    public function destroy(FooterSetting $footer)
    {
        if ($footer->logo && file_exists(public_path('uploads/footer/' . $footer->logo))) {
            unlink(public_path('uploads/footer/' . $footer->logo));
        }
        $footer->delete();

        return redirect()->route('footer.index')->with('success', 'Footer item deleted.');
    }
}
