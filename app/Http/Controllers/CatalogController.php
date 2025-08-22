<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        return view('catalog.index');
    }
    
    public function show(Product $product)
    {
        return view('catalog.show', compact('product'));
    }}
