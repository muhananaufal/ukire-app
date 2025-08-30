<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses Ditolak');
        }

        $order->load('items.product.images', 'user');

        return view('orders.show', compact('order'));
    }
}