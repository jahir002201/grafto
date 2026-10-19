<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Plant;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $plants = Plant::latest()->get();
        return view('home', compact('categories', 'plants'));
    }

    public function show(Plant $plant)
    {
        $plant->load('category');
        return view('Home.show', compact('plant'));
    }
    
}
