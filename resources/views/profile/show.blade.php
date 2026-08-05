@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Profile</h2>
        <div class="mb-4">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('dashboard.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Profile</a>
            <a href="{{ route('dashboard.profile.password') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Change Password</a>
        </div>
    </div>
</div>
@endsection