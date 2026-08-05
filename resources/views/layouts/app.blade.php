<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <title>Grafto Dashboard</title>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-800 text-white">

        <div class="p-6 text-2xl font-bold border-b border-green-700">
            🌿 Grafto
        </div>

        <nav class="mt-6">

            <a href="{{ route('dashboard') }}"
               class="block px-6 py-3 hover:bg-green-700">
                Dashboard
            </a>

            <a href="{{ url('categories') }}"
               class="block px-6 py-3 hover:bg-green-700">
                Categories
            </a>

            <a href="{{ route('categories.create') }}"
               class="block px-6 py-3 hover:bg-green-700">
                Add Category
            </a>

            <a href="{{ url('plants') }}"
               class="block px-6 py-3 hover:bg-green-700">
                Plants
            </a>

            <a href="{{ route('plants.create') }}"
               class="block px-6 py-3 hover:bg-green-700">
                Add Plant
            </a>

        </nav>

    </aside>

    <!-- Main Content -->
    <div class="flex-1">

        <!-- Header -->
        <header class="bg-white shadow px-8 py-5 flex justify-between items-center">

            <h1 class="text-2xl font-bold text-gray-700">
                Grafto Nursery Dashboard
            </h1>

            <div class="relative">

            <button
                onclick="document.getElementById('profileMenu').classList.toggle('hidden')"
                class="flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold uppercase">

                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}

            </button>

            <div
                id="profileMenu"
                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border">

                <div class="px-4 py-3 border-b">

                    <p class="font-semibold text-gray-700">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </p>

                </div>

                <a
                    href="{{ route('dashboard.profile.show') }}"
                    class="block px-4 py-2 hover:bg-gray-100">

                    My Profile

                </a>

                <a
                    href="{{ route('dashboard.profile.edit') }}"
                    class="block px-4 py-2 hover:bg-gray-100">

                    Edit Profile

                </a>

                <a
                    href="{{ route('dashboard.profile.password') }}"
                    class="block px-4 py-2 hover:bg-gray-100">

                    Change Password

                </a>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button
                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">

                        Logout

                    </button>

                </form>

            </div>

        </div>
        </header>

        <main class="p-8">

            @if(session('success'))
                <div class="mb-6 rounded bg-green-100 border border-green-300 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>