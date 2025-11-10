<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::latest()->get();
        return view('backend.team_members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('backend.team_members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        TeamMember::create($data);
        return redirect()->route('team-members.index')->with('success', 'Team member added successfully!');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('backend.team_members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $member->update($data);
        return redirect()->route('team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        if ($member->image && Storage::disk('public')->exists($member->image)) {
            Storage::disk('public')->delete($member->image);
        }
        $member->delete();
        return redirect()->route('team-members.index')->with('success', 'Team member deleted successfully!');
    }
}
