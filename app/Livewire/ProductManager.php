<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $code, $name, $price, $quantity, $description, $image, $existingImage;
    public $selectedProduct = null;
    public $view = 'list'; 
    protected $paginationTheme = 'bootstrap';
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            $this->reset(['email', 'password']);
            // Use redirect for SPA navigation (Livewire v3)
            return $this->redirect('/products');
            // Or, if you have a named route:
            // return $this->redirectRoute('products.index');
        } else {
            $this->addError('email', 'Invalid credentials.');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('success', 'Logged out.');
        $this->view = 'list';
    }
    
    protected function rules()
    {
        $uniqueCode = 'unique:products,code';
        if ($this->view === 'edit' && $this->selectedProduct) {
            $uniqueCode .= ',' . $this->selectedProduct->id;
        }
        return [
            'code' => 'required|string|max:255|' . $uniqueCode,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192'
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreate()
    {
        $this->resetForm();
        $this->view = 'create';
    }

    public function showEdit($id)
    {
        $product = Product::findOrFail($id);
        $this->selectedProduct = $product;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->quantity = $product->quantity;
        $this->description = $product->description;
        $this->existingImage = $product->image;
        $this->image = null;
        $this->view = 'edit';
    }

    public function showProduct($id)
    {
        $this->selectedProduct = Product::findOrFail($id);
        $this->view = 'show';
    }

    public function backToList()
    {
        $this->resetForm();
        $this->view = 'list';
    }

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
            try {
                // Log file details for debugging
                Log::info('Uploading file:', [
                    'original_name' => $this->image->getClientOriginalName(),
                    'mime_type' => $this->image->getMimeType(),
                    'extension' => $this->image->getClientOriginalExtension(),
                    'size' => $this->image->getSize()
                ]);
                
                $imagePath = $this->image->store('products', 'public');
                $product->image = $imagePath;
                
                Log::info('File uploaded successfully to: ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                session()->flash('error', 'Failed to upload image: ' . $e->getMessage());
                return;
            }
        }
        
        $product->save();
        session()->flash('success', 'Product created successfully.');
        $this->backToList();
    }

    public function update()
    {
        $this->validate();
        $product = $this->selectedProduct;
        $product->code = $this->code;
        $product->name = $this->name;
        $product->price = $this->price;
        $product->quantity = $this->quantity;
        $product->description = $this->description;
        
        if ($this->image) {
            try {
                // Delete old image if exists
                if ($this->existingImage) {
                    Storage::disk('public')->delete($this->existingImage);
                }
                
                // Log file details for debugging
                Log::info('Updating file:', [
                    'original_name' => $this->image->getClientOriginalName(),
                    'mime_type' => $this->image->getMimeType(),
                    'extension' => $this->image->getClientOriginalExtension(),
                    'size' => $this->image->getSize()
                ]);
                
                $imagePath = $this->image->store('products', 'public');
                $product->image = $imagePath;
                
                Log::info('File updated successfully to: ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('File update failed: ' . $e->getMessage());
                session()->flash('error', 'Failed to update image: ' . $e->getMessage());
                return;
            }
        }
        
        $product->save();
        session()->flash('success', 'Product updated successfully.');
        $this->backToList();
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

    public function resetForm()
    {
        $this->reset(['code', 'name', 'price', 'quantity', 'description', 'image', 'existingImage', 'selectedProduct']);
    }

    public function render()
    {
        if (Auth::check()) {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->paginate(4);
        } else {
            $products = new LengthAwarePaginator([], 0, 4);
        }
    
        return view('livewire.product-manager', compact('products'));;
    }
}
