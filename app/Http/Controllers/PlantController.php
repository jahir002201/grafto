<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants = Plant::latest()->paginate(2);

        return view('plants.index', compact('plants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('plants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'scientific_name' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'height' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:255',
            'watering' => 'nullable|string|max:255',
            'sunlight' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }
        Plant::create($validated);
        return redirect()->route('plants.index')->with('success', 'Plant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        return view('plants.show', compact('plant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plant $plant)
    {
        $categories = Category::all();
        return view('plants.edit', compact('plant', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plant $plant)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'scientific_name' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'height' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:255',
            'watering' => 'nullable|string|max:255',
            'sunlight' => 'nullable|string|max:255',
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($plant->image && Storage::disk('public')->exists($plant->image)) {
                Storage::disk('public')->delete($plant->image);
            }
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }
        $plant->update($validated);
        return redirect()->route('plants.index')->with('success', 'Plant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        if ($plant->image && Storage::disk('public')->exists($plant->image)) {
            Storage::disk('public')->delete($plant->image);
        }
        $plant->delete();
        return redirect()->route('plants.index')->with('success', 'Plant deleted successfully.');
    }
}
