@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create Plant</h1>
    <form action="{{ route('plants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Name
            </label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Description
            </label>
            <textarea
                name="description"
                id="description"
                rows="5"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >{{ old('description') }}</textarea>
        </div>
        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Image
            </label>
            <input
                type="file"
                name="image"
                id="image"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                Category
            </label>
            <select
                name="category_id"
                id="category_id"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <!-- Scientific Name -->
        <div>
            <label for="scientific_name" class="block text-sm font-medium text-gray-700 mb-2">
                Scientific Name
            </label>
            <input
                type="text"
                name="scientific_name"
                id="scientific_name"
                value="{{ old('scientific_name') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                Price
            </label>
            <input
                type="number"
                name="price"
                id="price"
                value="{{ old('price') }}"
                step="0.01"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                Stock
            </label>
            <input
                type="number"
                name="stock"
                id="stock"
                value="{{ old('stock') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Height -->
        <div>
            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                Height
            </label>
            <input
                type="text"
                name="height"
                id="height"
                value="{{ old('height') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Age -->
        <div>
            <label for="age" class="block text
-sm font-medium text-gray-700 mb-2">
                Age 
            </label>
            <input
                type="text"
                name="age"
                id="age"
                value="{{ old('age') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Watering -->
        <div>
            <label for="watering" class="block text-sm font-medium text-gray-700 mb-2">
                Watering
            </label>
            <input
                type="text"
                name="watering"
                id="watering"
                value="{{ old('watering') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Sunlight -->
        <div>
            <label for="sunlight" class="block text-sm font-medium text-gray-700 mb-2">
                Sunlight
            </label>
            <input
                type="text"
                name="sunlight"
                id="sunlight"
                value="{{ old('sunlight') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            >
        </div>
        <!-- Buttons -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700 transition"
            >
                Create Plant
            </button>

            <a href="{{ route('plants.index') }}"
               class="rounded-lg bg-gray-300 px-5 py-2.5 text-gray-800 hover:bg-gray-400 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection