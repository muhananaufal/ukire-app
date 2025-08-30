<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = \Cart::getContent();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        \Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price / 100,
            'quantity' => $request->quantity ?? 1,
            'attributes' => [
                'image' => $product->images->first()?->image_path,
                'slug' => $product->slug,
            ]
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $itemId)
    {
        \Cart::update($itemId, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy($itemId)
    {
        \Cart::remove($itemId);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
    }
}
