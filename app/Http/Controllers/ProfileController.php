<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            // Add other fields as necessary
        ]);

        // Update the authenticated user's profile
        $user = auth()->user();
        $user->update($validatedData);

        return redirect()->route('dashboard.profile.show')->with('success', 'Profile updated successfully.');
    }

    public function password()
    {
        return view('profile.password');
    }   

    public function updatePassword(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check if the current password matches
        if (!\Hash::check($validatedData['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the user's password
        $user->password = \Hash::make($validatedData['new_password']);
        $user->save();

        return redirect()->route('dashboard.profile.show')->with('success', 'Password updated successfully.');
    }
}
