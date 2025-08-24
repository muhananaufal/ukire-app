<?php

namespace App\Livewire;

use Livewire\Component;

class ShoppingCart extends Component
{
    public $cartItems;
    public $selectedItems = [];

    // Properti terhitung untuk total
    public function getSubtotalProperty()
    {
        return collect($this->cartItems)
            ->whereIn('id', array_keys(array_filter($this->selectedItems)))
            ->sum(fn($item) => $item->price * $item->quantity);
    }

    public function getTotalProperty()
    {
        return $this->subtotal;
    }

    public function mount()
    {
        $this->cartItems = \Cart::getContent()->sortBy('name');

        foreach ($this->cartItems as $item) {
            $this->selectedItems[$item->id] = true;
        }
    }

    public function toggleAll($value)
    {
        foreach ($this->cartItems as $item) {
            $this->selectedItems[$item->id] = (bool)$value;
        }
    }

    public function updateQuantity($itemId, $quantity)
    {
        $quantity = (int)$quantity; // Pastikan kuantitas adalah integer
        if ($quantity > 0) {
            \Cart::update($itemId, [
                'quantity' => [
                    'relative' => false, // <-- INI DIA SOLUSINYA
                    'value' => $quantity
                ],
            ]);
            $this->refreshCart();
        }
    }

    public function removeItem($itemId)
    {
        \Cart::remove($itemId);
        unset($this->selectedItems[$itemId]);
        $this->refreshCart();
        $this->dispatch('cartUpdated');
    }

    public function proceedToCheckout()
    {
        session(['selected_cart_items' => array_keys(array_filter($this->selectedItems))]);

        return redirect()->route('checkout.index');
    }

    public function refreshCart()
    {
        $this->cartItems = \Cart::getContent()->sortBy('name');
        $this->dispatch('cartUpdated');
        $this->dispatch('cart-refreshed');
    }

    public function render()
    {
        return view('livewire.shopping-cart')->layout('layouts.app');
    }
}
