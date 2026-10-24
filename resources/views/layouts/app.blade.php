<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Grafto Nursery')</title>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-green-800 text-white shrink-0">

        <div class="p-6 text-2xl font-bold border-b border-green-700">
            🌿 Grafto
        </div>

        <nav class="mt-6">

            @auth

                {{-- Admin navigation --}}
                @if(auth()->user()->role === 'admin')

                    <a href="{{ route('dashboard.index') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Dashboard
                    </a>

                    <a href="{{ route('dashboard.categories.index') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Categories
                    </a>

                    <a href="{{ route('dashboard.categories.create') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Add Category
                    </a>

                    <a href="{{ route('dashboard.plants.index') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Plants
                    </a>

                    <a href="{{ route('dashboard.plants.create') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Add Plant
                    </a>

                {{-- Customer navigation --}}
                @elseif(auth()->user()->role === 'customer')

                    <a href="{{ route('customer.dashboard') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        My Dashboard
                    </a>

                    <a href="{{ route('home') }}"
                       class="block px-6 py-3 hover:bg-green-700">
                        Shop / Home
                    </a>

                @endif

            @endauth

        </nav>

    </aside>

    {{-- Main content --}}
    <div class="flex-1 min-w-0">

        {{-- Header --}}
        <header class="bg-white shadow px-8 py-5 flex justify-between items-center">

            <h1 class="text-xl md:text-2xl font-bold text-gray-700">
                Grafto Nursery
            </h1>

            @auth
                <div class="relative">

                    <button
                        type="button"
                        onclick="document.getElementById('profileMenu').classList.toggle('hidden')"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold uppercase">

                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}

                    </button>

                    <div
                        id="profileMenu"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

                        <div class="px-4 py-3 border-b">

                            <p class="font-semibold text-gray-700">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-sm text-gray-500 break-words">
                                {{ auth()->user()->email }}
                            </p>

                            <p class="text-xs text-green-700 capitalize mt-1">
                                {{ auth()->user()->role }}
                            </p>

                        </div>

                        {{-- Role-specific profile links --}}
                        @if(auth()->user()->role === 'admin')

                            <a href="{{ route('dashboard.profile.show') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                My Profile
                            </a>

                            <a href="{{ route('dashboard.profile.edit') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                Edit Profile
                            </a>

                            <a href="{{ route('dashboard.profile.password') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                Change Password
                            </a>

                        @elseif(auth()->user()->role === 'customer')

                            <a href="{{ route('customer.profile.show') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                My Profile
                            </a>

                            <a href="{{ route('customer.profile.edit') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                Edit Profile
                            </a>

                            <a href="{{ route('customer.profile.password') }}"
                               class="block px-4 py-2 hover:bg-gray-100">
                                Change Password
                            </a>

                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>
            @else
                <div class="flex gap-4">
                    <a href="{{ route('login') }}"
                       class="text-green-700 hover:underline">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="text-green-700 hover:underline">
                        Register
                    </a>
                </div>
            @endauth

        </header>

        {{-- Page content --}}
        <main class="p-4 md:p-8">

            @if(session('success'))
                <div class="mb-6 rounded bg-green-100 border border-green-300 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded bg-red-100 border border-red-300 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>