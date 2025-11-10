<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::latest()->get();
        return view('backend.stats.index', compact('stats'));
    }
    public function create()
    {
        return view('backend.stats.create'); 
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Stat::create($data);
        return redirect()->route('stats.index')->with('success', 'Stat added successfully');
    }

    public function edit($id)
    {
        $stat = Stat::findOrFail($id);
        return view('backend.stats.edit', compact('stat'));
    }

    public function update(Request $request, $id)
    {
        $stat = Stat::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $stat->update($data);
        return redirect()->route('stats.index')->with('success', 'Stat updated successfully');
    }

    public function destroy($id)
    {
        Stat::findOrFail($id)->delete();
        return back()->with('success', 'Stat deleted successfully');
    }
}
