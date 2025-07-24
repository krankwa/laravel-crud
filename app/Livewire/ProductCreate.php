<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $code = '';
    public $name = '';
    public $price = '';
    public $quantity = '';
    public $description = '';
    public $image;

    protected $rules = [
        'code' => 'required|string|max:255|unique:products,code',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];

    public function save()
    {
        $this->validate();

        $product = new Product();
        $product->code = $this->code;
        $product->name = $this->name;
        $product->price = $this->price;
        $product->quantity = $this->quantity;
        $product->description = $this->description;

        if ($this->image) {
            $product->image = $this->image->store('products', 'public');
        }

        $product->save();

        session()->flash('success', 'Product created successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product-create');
    }
}