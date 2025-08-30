<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->where('is_published', true)
            ->with('category', 'images')
            ->filter(request(['search', 'category', 'sort']))
            ->paginate(4)
            ->withQueryString();

        return view('catalog.index', [
            'products' => $products,
            'categories' => Category::all()
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
