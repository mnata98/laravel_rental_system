<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class FrontendController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'available')->orderBy('created_at', 'desc')->get();
        return view('frontend.landing', compact('cars'));
    }
}
