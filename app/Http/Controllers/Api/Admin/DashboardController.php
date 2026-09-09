<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalPlants' => Plant::count(),
            'totalCategories' => Category::count(),
            'lowStockPlants' => Plant::where('stock', '<', 5)->count(),
            'latestPlants' => Plant::latest()->take(5)->get(),
        ]);
    }
}
