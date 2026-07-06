@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create Category</h1>

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                placeholder="Enter category name"
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
                placeholder="Enter category description"
            ></textarea>
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
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer file:bg-indigo-600 file:text-white file:border-0 file:px-4 file:py-2 file:mr-4 file:rounded-l-lg hover:file:bg-indigo-700"
            >
        </div>

        <!-- Submit Button -->
        <div>
            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200"
            >
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection