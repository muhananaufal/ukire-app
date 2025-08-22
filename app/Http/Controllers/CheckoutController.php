<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = \Cart::getContent();

        if (\Cart::isEmpty()) {
            return redirect()->route('catalog.index')->with('info', 'Your cart is empty. Please add products to checkout.');
        }

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $cartItems = \Cart::getContent();
        $totalPrice = \Cart::getTotal() * 100; // Simpan kembali ke unit sen/terkecil

        try {
            DB::beginTransaction();

            // 1. Create the Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending', // Status awal
                'shipping_address' => $request->shipping_address . ' | Phone: ' . $request->phone,
            ]);

            // 2. Create the Order Items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price * 100, // Simpan harga per item dalam unit terkecil
                ]);
            }

            DB::commit();

            // 3. Clear the cart
            \Cart::clear();

            // 4. Redirect to success page
            return redirect()->route('checkout.success', $order)->with('success', 'Your pre-order has been placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Opsional: Log error $e->getMessage()
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success(Order $order)
    {
        // Pastikan hanya user yang memiliki order yang bisa melihat halaman ini
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
