<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        return view('catalog.index', [
            'products' => Product::latest()
                ->with('category', 'images')
                ->filter(request(['search', 'category']))
                ->paginate(9)
                ->withQueryString(),
            'categories' => Category::all()
        ]);
    }

    public function show(Product $product)
    {
        // Eager load relationships for the single product view as well
        $product->load(['category', 'images']);

        return view('catalog.show', compact('product'));
    }
}
