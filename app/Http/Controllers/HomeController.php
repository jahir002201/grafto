<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();

        $plants = Plant::with('category')->latest()->get();

        return view('home', compact('categories', 'plants'));
    }

    public function show(Plant $plant)
    {
        $plant->load('category');

        return view('Home.show', compact('plant'));
    }
}