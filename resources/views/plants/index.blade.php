@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Plants
        </h1>

        <a href="{{ route('plants.create') }}"
           class="rounded-lg bg-blue-600 px-5 py-2.5 text-white shadow transition hover:bg-blue-700">
            + Create Plant
        </a>
    </div>

    @if($plants->count())
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($plants as $plant)

                <div class="overflow-hidden rounded-xl bg-white shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">

                    <a href="{{ route('plants.show', $plant->id) }}">
                        @if($plant->image)
                            <img
                                src="{{ Storage::url($plant->image) }}"
                                alt="{{ $plant->name }}"
                                class="h-56 w-full object-cover"
                            >
                        @else
                            <div class="flex h-56 items-center justify-center bg-gray-100">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                    </a>

                    <div class="p-5">

                        <h2 class="mb-2 text-xl font-semibold text-gray-800">
                            {{ $plant->name }}
                        </h2>

                        <p class="mb-6 text-gray-600">
                            {{ Str::limit($plant->description, 100) }}
                        </p>

                        <div class="flex items-center justify-between">

                            <a href="{{ url('plants/' . $plant->id) }}"
                               class="font-medium text-blue-600 hover:text-blue-800">
                                View →
                            </a>

                            <div class="flex gap-2">
                                <a href="{{ route('plants.edit', $plant->id) }}"
                                   class="rounded-lg bg-yellow-500 px-4 py-2 text-white transition hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('plants.destroy', $plant->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this plant?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-600 px-4 py-2 text-white transition hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-8">
            {{ $plants->links() }}
        </div>
    @else
        <div class="rounded-xl bg-white p-12 text-center shadow">
            <h2 class="text-xl font-semibold text-gray-700">
                No plants found
            </h2>

            <p class="mt-2 text-gray-500">
                Create your first plant to get started.
            </p>

            <a href="{{ route('plants.create') }}"
               class="mt-6 inline-block rounded-lg bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">
                Create Plant
            </a>
        </div>
    @endif

</div>
@endsection