@extends('layouts.app')
@section('content')
<!-- try better ui/ux -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Change Password</h2>
            <form action="{{ route('dashboard.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 font-medium mb-2">Current Password</label>
                    <input type="password" class="form-control border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" id="current_password" name="current_password" required>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 font-medium mb-2">New Password</label>
                    <input type="password" class="form-control border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" id="new_password" name="new_password" required>
                </div>
                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm New Password</label>
                    <input type="password" class="form-control border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Password</button>
            </form>
        </div>
    </div>
@endsection