@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Category</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Name
            </label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $category->name) }}"
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
            >{{ old('description', $category->description) }}</textarea>
        </div>

        <!-- Current Image -->
        @if($category->image)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Current Image
                </label>
                <img
                    src="{{ asset('storage/' . $category->image) }}"
                    alt="{{ $category->name }}"
                    class="h-32 w-32 rounded-lg object-cover border"
                >
            </div>
        @endif

        <!-- New Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Change Image
            </label>
            <input
                type="file"
                name="image"
                id="image"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-indigo-600 file:text-white file:border-0 file:px-4 file:py-2 file:mr-4 file:rounded-l-lg hover:file:bg-indigo-700"
            >
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition"
            >
                Update Category
            </button>

            <a
                href="{{ route('categories.index') }}"
                class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection