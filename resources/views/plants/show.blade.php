@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        
        @if($plant->image)
            <img
                src="{{ Storage::url($plant->image) }}"
                alt="{{ $plant->name }}"
                class="w-full h-96 object-cover"
            >
        @else
            <div class="flex h-96 items-center justify-center bg-gray-100">
                <span class="text-gray-500">No Image</span>
            </div>
        @endif

        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                {{ $plant->name }}
            </h1>

            <p class="text-gray-600 mb-6">
                {{ $plant->description }}
            </p>

            <p class="text-gray-500 text-sm">
                Category: {{ $plant->category->name }}
            </p>
        </div>
</div>
@endsection