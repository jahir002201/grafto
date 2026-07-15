<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Plant;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalPlants' => Plant::count(),
            'totalCategories' => Category::count(),
            'lowStockPlants' => Plant::where('stock', '<', 5)->count(),
            'latestPlants' => Plant::latest()->take(5)->get(),
        ]);
    }
}
