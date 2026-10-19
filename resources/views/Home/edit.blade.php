@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow-md">

        <h2 class="mb-6 text-2xl font-semibold text-gray-800">
            Edit Profile
        </h2>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('home.profile.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- Profile Image --}}
            <div class="mb-6">
                <label for="image"
                       class="mb-2 block font-medium text-gray-700">
                    Profile Image
                </label>

                @if ($user->image)
                    <img
                        src="{{ asset('storage/' . $user->image) }}"
                        alt="Profile Image"
                        class="mb-3 h-24 w-24 rounded-full border object-cover"
                    >
                @endif

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    class="block w-full rounded-md border border-gray-300 p-2"
                >

                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Name --}}
            <div class="mb-4">
                <label for="name"
                       class="mb-2 block font-medium text-gray-700">
                    Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email"
                       class="mb-2 block font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="mb-4">
                <label for="phone"
                       class="mb-2 block font-medium text-gray-700">
                    Phone Number
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    class="w-full rounded-md border border-gray-300 px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div class="mb-6">
                <label for="address"
                       class="mb-2 block font-medium text-gray-700">
                    Address
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    class="w-full rounded-md border border-gray-300 px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                >{{ old('address', $user->address) }}</textarea>

                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-blue-500 px-5 py-2 text-white
                           hover:bg-blue-600"
                >
                    Update Profile
                </button>

                <a
                    href="{{ route('home.profile.show') }}"
                    class="rounded-md bg-gray-200 px-5 py-2 text-gray-700
                           hover:bg-gray-300"
                >
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection