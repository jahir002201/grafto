<!-- category show -->
<h1>{{ $category->name }}</h1>

<p>{{ $category->description }}</p>

@if ($category->image)
    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-fluid">
@endif
