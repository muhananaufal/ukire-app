<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('images', 'category')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $newestProducts = Product::with('images', 'category')
            ->latest()
            ->limit(4)
            ->get();

        return view('home', compact('featuredProducts', 'newestProducts'));
    }
}
