<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Dashboard data fetched successfully',

            'data' => [
                'totalPlants' => Plant::count(),

                'totalCategories' => Category::count(),

                'lowStockPlants' => Plant::where('stock', '<', 5)->count(),

                'latestPlants' => Plant::with('category')
                    ->latest()
                    ->take(5)
                    ->get(),
            ],
        ]);
    }
}