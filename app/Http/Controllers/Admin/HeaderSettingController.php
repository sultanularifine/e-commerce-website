<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;

class HeaderSettingController extends Controller
{
public function index()
{
    $settings = HeaderSetting::orderBy('order')->paginate(10); // paginate 10 items per page
    return view('backend.header.index', compact('settings'));
}

    public function create()
    {
        return view('backend.header.edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'nullable|string',
            'icon' => 'nullable|string',
            'value' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        HeaderSetting::create($request->all());

        return redirect()->route('header-settings.index')->with('success', 'Header item added.');
    }

    public function edit(HeaderSetting $headerSetting)
    {
        return view('backend.header.edit', compact('headerSetting'));
    }

    public function update(Request $request, HeaderSetting $headerSetting)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'nullable|string',
            'icon' => 'nullable|string',
            'value' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $headerSetting->update($request->all());

        return redirect()->route('header-settings.index')->with('success', 'Header item updated.');
    }

    public function destroy(HeaderSetting $headerSetting)
    {
        $headerSetting->delete();
        return redirect()->route('header-settings.index')->with('success', 'Header item deleted.');
    }
}
