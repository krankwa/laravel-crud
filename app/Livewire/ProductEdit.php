<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductEdit extends Component
{
    use WithFileUploads;

    public Product $product;
    public $code;
    public $name;
    public $price;
    public $quantity;
    public $description;
    public $image;
    public $existingImage;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->description = $product->description;
        $this->existingImage = $product->image;
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:products,code,' . $this->product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function update()
    {
        $this->validate();

        $this->product->code = $this->code;
        $this->product->name = $this->name;
        $this->product->price = $this->price;
        $this->product->quantity = $this->quantity;
        $this->product->description = $this->description;

        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $this->product->image = $this->image->store('products', 'public');
        }

        $this->product->save();

        session()->flash('success', 'Product updated successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product-edit');
    }
}