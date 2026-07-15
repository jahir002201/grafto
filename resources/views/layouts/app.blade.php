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

            <div class="text-gray-600">
                <img src="{{ url('https://my-portfolio-smoky-xi-63.vercel.app/_next/image?url=%2Fimages%2FJahir.jpg&w=96&q=75') }}" alt="Profile" class="w-10 h-10 rounded-full">
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