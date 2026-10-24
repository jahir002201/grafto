@extends('layouts.home')

@section('title', $plant->name . ' | Grafto')

@section('content')
<section class="min-h-screen bg-gray-50 py-12">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <a href="{{ route('home') }}"
           class="mb-6 inline-block font-semibold text-green-700 hover:text-green-900">
            ← Back to Home
        </a>

        <div class="grid gap-10 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2 md:p-10">

            <div>
                @if ($plant->image)
                    <img
                        src="{{ \Illuminate\Support\Str::startsWith($plant->image, ['http://', 'https://']) ? $plant->image : asset('storage/' . $plant->image) }}"
                        alt="{{ $plant->name }}"
                        class="h-96 w-full rounded-xl object-cover"
                    >
                @else
                    <div class="flex h-96 items-center justify-center rounded-xl bg-green-100 text-7xl">
                        🪴
                    </div>
                @endif
            </div>

            <div>
                <p class="font-semibold text-green-700">
                    {{ $plant->category?->name ?? 'Nursery Plant' }}
                </p>

                <h1 class="mt-3 text-3xl font-extrabold text-gray-900">
                    {{ $plant->name }}
                </h1>

                @if ($plant->scientific_name)
                    <p class="mt-2 italic text-gray-500">
                        {{ $plant->scientific_name }}
                    </p>
                @endif

                <p class="mt-5 text-3xl font-extrabold text-green-800">
                    ৳{{ number_format((float) $plant->price, 2) }}
                </p>

                <p class="mt-4 {{ $plant->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
                    {{ $plant->stock > 0 ? 'In Stock (' . $plant->stock . ')' : 'Out of Stock' }}
                </p>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-bold text-gray-900">
                        Plant Description
                    </h2>

                    <p class="mt-3 whitespace-pre-line leading-7 text-gray-600">
                        {{ $plant->description ?: 'No description available.' }}
                    </p>
                </div>

                @if ($plant->height)
                    <p class="mt-4 text-gray-700">
                        <strong>Height:</strong> {{ $plant->height }}
                    </p>
                @endif

                @if ($plant->age)
                    <p class="mt-2 text-gray-700">
                        <strong>Age:</strong> {{ $plant->age }}
                    </p>
                @endif

                @if ($plant->sunlight)
                    <p class="mt-2 text-gray-700">
                        <strong>Sunlight:</strong> {{ $plant->sunlight }}
                    </p>
                @endif

                @if ($plant->watering)
                    <p class="mt-2 text-gray-700">
                        <strong>Watering:</strong> {{ $plant->watering }}
                    </p>
                @endif
            </div>
            @if ($plant->stock > 0)
                <form
                    action="{{ route('payment.plant.checkout', $plant) }}"
                    method="POST"
                    class="mt-6 space-y-4"
                >
                    @csrf

                    <div>
                        <label for="quantity" class="block font-semibold text-gray-700">
                            Quantity
                        </label>

                        <input
                            id="quantity"
                            type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            max="{{ $plant->stock }}"
                            required
                            class="mt-2 w-24 rounded-lg border border-gray-300 px-3 py-2"
                        >

                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-700 px-6 py-3 font-bold text-white hover:bg-green-800 sm:w-auto"
                    >
                        Buy Now — ৳{{ number_format((float) $plant->price, 2) }}
                    </button>
                </form>
            @else
                <button
                    type="button"
                    disabled
                    class="mt-6 cursor-not-allowed rounded-xl bg-gray-300 px-6 py-3 font-bold text-gray-600"
                >
                    Out of Stock
                </button>
            @endif

        </div>
    </div>
</section>
@endsection