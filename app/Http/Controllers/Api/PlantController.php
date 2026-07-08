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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
