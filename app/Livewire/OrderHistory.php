<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $totalSpent;
    public $totalOrders;
    public $favoriteCategory;

    public function mount()
    {
        $user = Auth::user();
        $this->totalSpent = $user->orders()->whereIn('status', ['processing', 'shipped', 'completed'])->sum('total_price');
        $this->totalOrders = $user->orders()->count();

        // Query untuk mencari kategori favorit berdasarkan jumlah item yang dibeli
        $this->favoriteCategory = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.user_id', $user->id)
            ->select('categories.name', DB::raw('count(order_items.id) as item_count'))
            ->groupBy('categories.name')
            ->orderByDesc('item_count')
            ->first()?->name;
    }

    public function reorder(Order $order)
    {
        foreach ($order->items as $item) {
            \Cart::add([
                'id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->price / 100,
                'quantity' => $item->quantity,
                'attributes' => [
                    'image' => $item->product->images->first()?->image_path,
                    'slug' => $item->product->slug,
                ]
            ]);
        }

        $this->dispatch('cartUpdated');
        return $this->redirect(route('cart.index'), navigate: true);
    }

    public function updating($property)
    {
        if (in_array($property, ['search', 'statusFilter', 'dateFrom', 'dateTo'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset();
    }

    public function render()
    {
        $ordersQuery = Auth::user()->orders()
            ->with('items') // Eager load untuk efisiensi
            ->latest();

        // Terapkan filter pencarian
        if ($this->search) {
            $ordersQuery->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('items.product', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Terapkan filter status
        if ($this->statusFilter) {
            $ordersQuery->where('status', $this->statusFilter);
        }

        // Terapkan filter tanggal
        if ($this->dateFrom) {
            $ordersQuery->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $ordersQuery->whereDate('created_at', '<=', $this->dateTo);
        }

        return view('livewire.order-history', [
            'orders' => $ordersQuery->paginate(10)
        ])->layout('layouts.app');
    }
}
