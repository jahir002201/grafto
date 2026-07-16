<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalPlants' => \App\Models\Plant::count(),
            'totalCategories' => \App\Models\Category::count(),
            'lowStockPlants' => \App\Models\Plant::where('stock', '<', 5)->count(),
            'latestPlants' => \App\Models\Plant::latest()->take(5)->get(),
        ]);
    }
}
