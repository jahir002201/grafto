@extends('layouts.home')

@section('title', 'Profile | Grafto')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">

            {{-- Page Heading --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="mt-2 text-gray-600">
                    Manage your account settings and personal information.
                </p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

                {{-- Profile Header --}}
                <div class="bg-green-700 px-6 py-8 sm:px-8">
                    <div class="flex flex-col items-center gap-5 sm:flex-row">

                        {{-- Profile Image --}}
                        @if ($user->image)
                            <img
                                src="{{ asset('storage/' . $user->image) }}"
                                alt="{{ $user->name }}"
                                class="h-24 w-24 rounded-full border-4 border-white object-cover shadow"
                            >
                        @else
                            <div class="flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-green-100 text-3xl font-bold text-green-800 shadow">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-white">
                                {{ $user->name }}
                            </h2>
                            <p class="mt-1 text-green-100">
                                {{ $user->email }}
                            </p>
                            <p class="mt-2 text-sm text-green-100">
                                Grafto Account
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Account Information --}}
                <div class="p-6 sm:p-8">
                    <h3 class="mb-6 text-xl font-semibold text-gray-900">
                        Account Information
                    </h3>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        {{-- Name --}}
                        <div class="rounded-lg bg-gray-50 p-4">
                            <p class="text-sm font-medium text-gray-500">
                                Full Name
                            </p>
                            <p class="mt-2 break-words font-semibold text-gray-900">
                                {{ $user->name }}
                            </p>
                        </div>

                        {{-- Email --}}
                        <div class="rounded-lg bg-gray-50 p-4">
                            <p class="text-sm font-medium text-gray-500">
                                Email Address
                            </p>
                            <p class="mt-2 break-words font-semibold text-gray-900">
                                {{ $user->email }}
                            </p>
                        </div>

                        {{-- Phone --}}
                        <div class="rounded-lg bg-gray-50 p-4">
                            <p class="text-sm font-medium text-gray-500">
                                Phone Number
                            </p>
                            <p class="mt-2 font-semibold text-gray-900">
                                {{ $user->phone ?: 'Not provided' }}
                            </p>
                        </div>

                        {{-- Address --}}
                        <div class="rounded-lg bg-gray-50 p-4">
                            <p class="text-sm font-medium text-gray-500">
                                Address
                            </p>
                            <p class="mt-2 break-words font-semibold text-gray-900">
                                {{ $user->address ?: 'Not provided' }}
                            </p>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex flex-wrap gap-3 border-t border-gray-200 pt-6">

                        <a
                            href="{{ route('customer.profile.edit') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 font-semibold text-white transition hover:bg-green-800"
                        >
                            Edit Profile
                        </a>

                        <a
                            href="{{ route('customer.profile.password') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-5 py-3 font-semibold text-white transition hover:bg-amber-600"
                        >
                            Change Password
                        </a>

                        <a
                            href="{{ route('home') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-100"
                        >
                            Back to Home
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection