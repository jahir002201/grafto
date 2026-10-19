@extends('layouts.home')

@section('title', 'Grafto | Grow Your Garden')

@section('content')

    {{-- Hero section --}}
    <section class="bg-green-950 text-white">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 py-20 md:grid-cols-2 lg:px-8 lg:py-28">

            <div>
                <p class="font-semibold uppercase tracking-widest text-lime-400">
                    Welcome to Grafto Nursery
                </p>

                <h1 class="mt-5 text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">
                    Grow Your Dream
                    <span class="text-lime-400">Garden.</span>
                </h1>

                <p class="mt-6 max-w-lg leading-7 text-green-100">
                    Discover fruit plants, beautiful flowers, indoor greenery
                    and grafted trees for your garden.
                </p>

                <a href="#plants"
                   class="mt-8 inline-block rounded-lg bg-lime-400 px-6 py-3 font-bold text-green-950 hover:bg-lime-300">
                    Explore Plants →
                </a>
            </div>

            <div>
                <img
                    src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=1000&q=85"
                    alt="Green plants at a nursery"
                    class="h-72 w-full rounded-3xl object-cover shadow-2xl sm:h-96"
                >
            </div>

        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
        <h2 class="text-3xl font-extrabold">Plant Categories</h2>
        <p class="mt-2 text-gray-500">Explore our nursery collection.</p>

        <div class="mt-8 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-6">
            @forelse($categories as $category)
                <a href="#plants"
                   class="rounded-2xl border border-gray-100 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                    @if($category->image)
                        <img
                            src="{{ \Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : asset('storage/'.$category->image) }}"
                            alt="{{ $category->name }}"
                            class="mx-auto h-20 w-20 rounded-full object-cover"
                        >
                    @else
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-3xl">
                            🌱
                        </div>
                    @endif

                    <h3 class="mt-4 font-bold">{{ $category->name }}</h3>
                </a>
            @empty
                <p class="col-span-full text-gray-500">No categories available yet.</p>
            @endforelse
        </div>
    </section>

    {{-- Plants --}}
    <section id="plants" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <h2 class="text-3xl font-extrabold">Featured Plants</h2>
            <p class="mt-2 text-gray-500">Find the right plants for your garden.</p>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($plants as $plant)
                    <article class="overflow-hidden rounded-2xl border border-gray-100 bg-stone-50 shadow-sm transition hover:shadow-lg">

                        @if($plant->image)
                            <img
                                src="{{ \Illuminate\Support\Str::startsWith($plant->image, ['http://', 'https://']) ? $plant->image : asset('storage/'.$plant->image) }}"
                                alt="{{ $plant->name }}"
                                class="h-52 w-full object-cover"
                            >
                        @else
                            <div class="flex h-52 items-center justify-center bg-green-100 text-6xl">
                                🪴
                            </div>
                        @endif
                        <a href="{{ route('home.plants.show', $plant) }}" class="block">
                        <div class="p-5">
                            <p class="text-sm text-green-700">
                                {{ $plant->category?->name ?? 'Nursery Plant' }}
                            </p>

                            <h3 class="mt-2 text-lg font-bold">{{ $plant->name }}</h3>

                            <p class="mt-3 text-xl font-extrabold text-green-800">
                                ৳{{ number_format((float) $plant->price, 2) }}
                            </p>

                            <p class="mt-2 text-sm {{ $plant->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
                                {{ $plant->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </p>
                        </div>
                        </a>
                    </article>
                @empty
                    <p class="col-span-full rounded-xl bg-stone-50 p-8 text-gray-500">
                        No plants available yet. Add plants through your dashboard.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
        <div class="rounded-3xl bg-green-100 p-8 sm:p-12">
            <h2 class="text-3xl font-extrabold">Grow Naturally with Grafto</h2>

            <p class="mt-4 max-w-2xl leading-7 text-gray-600">
                From fruit trees to flowering plants, discover greenery
                that makes your home and garden more beautiful.
            </p>

            <a href="#plants"
               class="mt-6 inline-block rounded-lg bg-green-800 px-6 py-3 font-semibold text-white hover:bg-green-900">
                Browse Plants
            </a>
        </div>
    </section>

@endsection