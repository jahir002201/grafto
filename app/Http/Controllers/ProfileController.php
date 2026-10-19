<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        if($request->routeIs('home.profile.show')) {
            return view('Home.profile', compact('user'));
        }

        return view('profile.show', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        if($request->routeIs('home.profile.edit')) {
            return view('Home.edit', compact('user'));
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Remove the uploaded file from ordinary model update data.
        unset($validatedData['image']);

        if ($request->hasFile('image')) {
            $oldImage = $user->image;

            $validatedData['image'] = $request->file('image')
                ->store('profiles', 'public');

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $user->update($validatedData);

        // Return to the profile page the user came from.
        if ($request->routeIs('home.profile.update')) {
            return redirect()->route('home.profile.show')
                ->with('success', 'Profile updated successfully.');
        }

        return redirect()->route('dashboard.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function password(Request $request)
    {
        if (request()->routeIs('home.profile.password')) {
            return view('Home.password');
        }
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validatedData['new_password']),
        ]);

        if ($request->routeIs('home.profile.update-password')) {
            return redirect()->route('home.profile.show')
                ->with('success', 'Password updated successfully.');
        }

        return redirect()->route('dashboard.profile.show')
            ->with('success', 'Password updated successfully.');
    }
}