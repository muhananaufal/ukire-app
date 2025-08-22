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
        $totalPrice = \Cart::getTotal();

        try {
            DB::beginTransaction();

            // 1. Create the Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice * 100,
                'status' => 'unpaid', // Status awal
                'shipping_address' => $request->shipping_address . ' | Phone: ' . $request->phone,
            ]);

            // 2. Create the Order Items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price * 100,
                ]);
            }

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => auth()->user()->email,
                    'phone' => $request->phone,
                    'shipping_address' => [
                        'address' => $request->shipping_address,
                    ],
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();
            \Cart::clear();

            return view('checkout.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            DB::rollBack();
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
