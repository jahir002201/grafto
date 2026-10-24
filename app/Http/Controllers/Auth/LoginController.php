<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::guard('web')->attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard.index')
                ->with('success', 'Welcome back, Admin!');
        }

        if ($user->isCustomer()) {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Welcome to Grafto!');
        }

        Auth::guard('web')->logout();

        abort(403, 'Your account has an invalid role.');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have logged out successfully.');
    }
}
