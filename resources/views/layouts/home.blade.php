<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Grafto | Nursery & Plants')</title>
</head>

<body class="min-h-screen bg-stone-50 text-gray-800 antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white shadow-sm">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold text-green-800">
                🌿 Grafto
            </a>

            <div class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}"
                   class="font-medium hover:text-green-700">
                    Home
                </a>

                <a href="{{ route('home') }}#categories"
                   class="font-medium hover:text-green-700">
                    Categories
                </a>

                <a href="{{ route('home') }}#plants"
                   class="font-medium hover:text-green-700">
                    Plants
                </a>

                <a href="{{ route('home') }}#about"
                   class="font-medium hover:text-green-700">
                    About Us
                </a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('home.profile.show') }}"
                       class="rounded-lg bg-green-700 px-4 py-2 font-semibold text-white hover:bg-green-800">
                        Profile
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden font-semibold text-green-700 sm:block">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-green-700 px-4 py-2 font-semibold text-white hover:bg-green-800">
                        Register
                    </a>
                @endauth

                <button type="button"
                        id="mobileMenuButton"
                        aria-label="Toggle navigation menu"
                        aria-expanded="false"
                        aria-controls="mobileMenu"
                        class="rounded-lg border border-gray-200 p-2 md:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile navigation --}}
        <div id="mobileMenu" class="hidden border-t border-gray-100 bg-white px-5 py-4 md:hidden">
            <div class="flex flex-col gap-4">
                <a href="{{ route('home') }}" class="hover:text-green-700">Home</a>
                <a href="{{ route('home') }}#categories" class="hover:text-green-700">Categories</a>
                <a href="{{ route('home') }}#plants" class="hover:text-green-700">Plants</a>
                <a href="{{ route('home') }}#about" class="hover:text-green-700">About Us</a>

                @guest
                    <a href="{{ route('login') }}" class="hover:text-green-700">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-green-700">Register</a>
                @endguest
            </div>
        </div>
    </header>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mx-auto mt-5 max-w-7xl px-5 lg:px-8">
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-auto mt-5 max-w-7xl px-5 lg:px-8">
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Page content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-green-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-12 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">

            <div>
                <a href="{{ route('home') }}" class="text-2xl font-extrabold">
                    🌿 Grafto
                </a>

                <p class="mt-4 max-w-sm leading-7 text-green-100">
                    Discover beautiful plants and bring more greenery
                    into your home and garden.
                </p>
            </div>

            <div>
                <h3 class="font-bold">Quick Links</h3>
                <div class="mt-4 flex flex-col gap-3 text-green-100">
                    <a href="{{ route('home') }}" class="hover:text-lime-400">Home</a>
                    <a href="{{ route('home') }}#categories" class="hover:text-lime-400">Categories</a>
                    <a href="{{ route('home') }}#plants" class="hover:text-lime-400">Plants</a>
                    <a href="{{ route('home') }}#about" class="hover:text-lime-400">About Us</a>
                </div>
            </div>

            <div>
                <h3 class="font-bold">Account</h3>
                <div class="mt-4 flex flex-col gap-3 text-green-100">
                    @auth
                        <a href="{{ route('home.profile.show') }}" class="hover:text-lime-400">
                            Profile
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-lime-400">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="hover:text-lime-400">
                            Register
                        </a>
                    @endauth
                </div>
            </div>

        </div>

        <div class="border-t border-white/10 px-5 py-5 text-center text-sm text-green-100">
            &copy; {{ date('Y') }} Grafto Nursery. All rights reserved.
        </div>
    </footer>

    {{-- Mobile menu script --}}
    <script>
        const menuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        menuButton?.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');

            menuButton.setAttribute('aria-expanded', String(!isHidden));
        });
    </script>

</body>
</html>