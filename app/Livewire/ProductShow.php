<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductShow extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}