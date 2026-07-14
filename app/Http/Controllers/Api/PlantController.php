<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plant;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants = Plant::latest()->paginate(2);

        return response()->json([
            'success' => true,
            'data' => $plants
        ]);
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

        $plant = Plant::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Plant created successfully.',
            'data' => $plant
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plant = Plant::find($id);
        if (!$plant) {
            return response()->json([
                'success' => false,
                'message' => 'Plant not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $plant
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plant = Plant::find($id);
        if (!$plant) {
            return response()->json([
                'success' => false,
                'message' => 'Plant not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'sometimes|required|exists:categories,id',
            'scientific_name' => 'nullable|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'height' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:255',
            'watering' => 'nullable|string|max:255',
            'sunlight' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($plant->image && Storage::disk('public')->exists($plant->image)) {
                Storage::disk('public')->delete($plant->image);
            }
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        $plant->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Plant updated successfully.',
            'data' => $plant
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plant = Plant::find($id);
        if (!$plant) {
            return response()->json([
                'success' => false,
                'message' => 'Plant not found'
                ], 404);
        }
        if ($plant->image && Storage::disk('public')->exists($plant->image)) {
            Storage::disk('public')->delete($plant->image);
        }
        $plant->delete();
        return response()->json([
            'success' => true,
            'message' => 'Plant deleted successfully'
        ]);
    }
}
