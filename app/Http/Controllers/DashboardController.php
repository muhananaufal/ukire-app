<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeOrders = $user->orders()
            ->whereIn('status', ['unpaid', 'processing', 'shipped'])
            ->with('items.product.images')
            ->latest()
            ->take(3)
            ->get();

        $stats = [
            'total_spent' => $user->orders()->whereIn('status', ['processing', 'shipped', 'completed'])->sum('total_price'),
            'total_orders' => $user->orders()->count(),
            'total_items' => $user->orders()->withSum('items', 'quantity')->get()->sum('items_sum_quantity'),
        ];

        return view('dashboard', [
            'activeOrders' => $activeOrders,
            'stats' => $stats,
        ]);
    }
}
