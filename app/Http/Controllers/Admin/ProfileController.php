<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
   
    public function show()
    {
        $user = Auth::user();
        return view('backend.profile.show', compact('user'));
    }


    public function settings()
    {
        $user = Auth::user();
        return view('backend.profile.index', compact('user'));
    }

   
   public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('avatar')) {
        if ($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar))) {
            unlink(public_path('uploads/avatars/' . $user->avatar));
        }

        $file = $request->file('avatar');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/avatars'), $filename);
        $user->avatar = $filename;
    }

    $user->save(); // 

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}
}
