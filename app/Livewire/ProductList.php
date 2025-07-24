<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductList extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            session()->flash('success', 'Product deleted successfully.');
        }
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(4);
            
        return view('livewire.product-list', compact('products'));
    }
}
