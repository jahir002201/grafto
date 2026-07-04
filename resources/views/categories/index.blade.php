@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Categories
        </h1>

        <a href="{{ route('categories.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition">
            + Create Category
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach ($categories as $category)

        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">

            @if($category->image)
                <img src="{{ Storage::url($category->image) }}"
                     alt="{{ $category->name }}"
                     class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif

            <div class="p-5">

                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    {{ $category->name }}
                </h2>

                <p class="text-gray-600 mb-5">
                    {{ $category->description }}
                </p>

                <div class="flex justify-between">

                    <a href="{{ route('categories.edit', $category->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                        Edit
                    </a>

                    <form action="{{ route('categories.destroy', $category->id) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this category?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                            Delete
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    <div class="mt-8 flex justify-center">
        {{ $categories->links() }}
    </div>

</div>
@endsection