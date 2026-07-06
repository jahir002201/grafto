@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        @if ($category->image)
            <img src="{{ Storage::url($category->image) }}"
                 class="h-64 sm:h-80 object-cover mx-auto">
        @endif

        <div class="text-center p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                {{ $category->name }}
            </h1>

            <p class="mt-4 text-gray-600">
                {{ $category->description ?: 'No description available.' }}
            </p>

            <div class="mt-8 flex gap-3 justify-center">

                <a href="{{ route('categories.edit', $category->id) }}"
                   class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700">
                    Edit
                </a>

                <a href="{{ route('categories.index') }}"
                   class="border px-5 py-3 rounded-lg hover:bg-gray-100">
                    Back
                </a>

            </div>

        </div>
    </div>

</div>
@endsection