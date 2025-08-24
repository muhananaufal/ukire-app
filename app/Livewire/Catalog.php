<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public $search = '';

    #[Url(except: '')]
    public $category = '';

    #[Url(except: '')]
    public $sort = 'latest';

    public $viewType = 'grid';

    public ?Product $quickViewProduct = null;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'category', 'sort'])) {
            $this->resetPage();
        }
    }

    public function quickView($productId)
    {
        $this->quickViewProduct = Product::with('images', 'category')->findOrFail($productId);
    }

    public function closeQuickView()
    {
        $this->quickViewProduct = null;
    }

    public function clearFilters()
    {
        $this->reset(['search', 'category', 'sort']);
    }

    public function render()
    {
        $productsQuery = Product::query()
            ->where('is_published', true)
            ->with('category', 'images');

        if ($this->search) {
            $productsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->category) {
            $productsQuery->whereHas('category', function ($query) {
                $query->where('slug', $this->category);
            });
        }

        if ($this->sort === 'price_asc') {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($this->sort === 'price_desc') {
            $productsQuery->orderBy('price', 'desc');
        } else {
            $productsQuery->latest();
        }

        return view('livewire.catalog', [
            'products' => $productsQuery->paginate(12),
            'categories' => Category::all()
        ])->layout('layouts.app');
    }
}
