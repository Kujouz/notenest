<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        // Build validation rules dynamically based on user role
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // Only require id_number for students
        if (Auth::user()->role === 'student') {
            $rules['id_number'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Only update id_number for students
        if (Auth::user()->role === 'student') {
            $user->id_number = $request->id_number;
        }

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Handle password
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        Auth::setUser($user->fresh());

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
