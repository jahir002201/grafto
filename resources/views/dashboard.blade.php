@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-8">
    Dashboard
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-gray-500">Total Plants</h2>

        <p class="text-4xl font-bold text-green-600 mt-2">
            {{ $totalPlants }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-gray-500">Categories</h2>

        <p class="text-4xl font-bold text-blue-600 mt-2">
            {{ $totalCategories }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-gray-500">Low Stock</h2>

        <p class="text-4xl font-bold text-red-600 mt-2">
            {{ $lowStockPlants }}
        </p>
    </div>

</div>

<div class="bg-white rounded-xl shadow mt-8">

    <div class="border-b px-6 py-4">
        <h2 class="text-xl font-semibold">
            Latest Plants
        </h2>
    </div>

    <table class="w-full">

        <thead>

        <tr class="bg-gray-100">

            <th class="p-4 text-left">Image</th>
            <th class="p-4 text-left">Name</th>
            <th class="p-4 text-left">Price</th>
            <th class="p-4 text-left">Stock</th>
            <th class="p-4 text-left">Action</th>

        </tr>

        </thead>

        <tbody>

        @foreach($latestPlants as $plant)

            <tr class="border-t">

                <td class="p-4">

                    @if($plant->image)

                        <img src="{{ Storage::url($plant->image) }}"
                             class="w-16 h-16 rounded object-cover">

                    @endif

                </td>

                <td class="p-4">
                    {{ $plant->name }}
                </td>

                <td class="p-4">
                    ৳{{ number_format($plant->price,2) }}
                </td>

                <td class="p-4">
                    {{ $plant->stock }}
                </td>

                <td class="p-4 flex gap-2">

                    <a href="{{ route('plants.edit', $plant->id) }}"
                       class="rounded-lg bg-yellow-500 px-4 py-2 text-white transition hover:bg-yellow-600">
                        Edit
                    </a>

                    <form action="{{ route('plants.destroy', $plant->id) }}"
                          method="POST"
                          class="inline-block"
                          onsubmit="return confirm('Delete this plant?')">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-white transition hover:bg-red-700">
                            Delete
                        </button>

                    </form>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection