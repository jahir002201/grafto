<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //user profile
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user,
        ]);
    }
}
