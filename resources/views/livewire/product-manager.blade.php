<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($view === 'list')
        <div class="card">
            <div class="card-header">
                <div class="float-start">Product List</div>
                <div class="float-end">
                    <form action="{{ route('logout') }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to logout?');">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search products...">
                </div>
                <button wire:click="showCreate" class="btn btn-success btn-sm my-2">
                    <i class="bi bi-plus-circle"></i> Add New Product
                </button>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         width="50" 
                                         height="50" 
                                         class="img-thumbnail"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                                    <span style="display: none;" class="text-danger">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </span>
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="showProduct({{ $product->id }})" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Show
                                </button>
                                <button wire:click="showEdit({{ $product->id }})" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <button wire:click="delete({{ $product->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                        class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    @elseif ($view === 'create')
        <div class="card">
            <div class="card-header">
                <div class="float-start">Add New Product</div>
                <div class="float-end">
                    <button wire:click="backToList" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="mb-3 row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start">Code</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="Enter product code">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter product name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                        <div class="col-md-6">
                            <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" id="price" step="0.01" placeholder="Enter price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                        <div class="col-md-6">
                            <input type="number" wire:model="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" min="0" placeholder="Enter quantity">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="Enter product description"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="image" class="col-md-4 col-form-label text-md-end text-start">Image</label>
                        <div class="col-md-6">
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" id="image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" width="100">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @elseif ($view === 'edit')
        <div class="card">
            <div class="card-header">
                <div class="float-start">Edit Product</div>
                <div class="float-end">
                    <button wire:click="backToList" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="mb-3 row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start">Code</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" id="code">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                        <div class="col-md-6">
                            <input type="number" wire:model="price" class="form-control @error('price') is-invalid @enderror" id="price" step="0.01">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                        <div class="col-md-6">
                            <input type="number" wire:model="quantity" class="form-control @error('quantity') is-invalid @enderror" id="quantity" min="0">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="image" class="col-md-4 col-form-label text-md-end text-start">Image</label>
                        <div class="col-md-6">
                            <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" id="image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if ($image)
                                <div class="mt-2">
                                    <strong>New Image Preview:</strong><br>
                                    <img src="{{ $image->temporaryUrl() }}" alt="New Preview" width="100">
                                </div>
                            @endif
                            @if ($existingImage && !$image)
                                <div class="mt-2">
                                    <strong>Current Image:</strong><br>
                                    <img src="{{ asset('storage/' . $existingImage) }}" alt="Current Image" width="100">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @elseif ($view === 'show')
        <div class="card">
            <div class="card-header">
                <div class="float-start">Product Details</div>
                <div class="float-end">
                    <button wire:click="backToList" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Code:</strong> {{ $product->code }}
                        </div>
                        <div class="mb-3">
                            <strong>Name:</strong> {{ $product->name }}
                        </div>
                        <div class="mb-3">
                            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                        </div>
                        <div class="mb-3">
                            <strong>Quantity:</strong> {{ $product->quantity }}
                        </div>
                        <div class="mb-3">
                            <strong>Description:</strong> 
                            <p>{{ $product->description ?: 'No description available' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Image:</strong><br>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-fluid border" 
                                     style="max-width: 300px; max-height: 300px;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div style="display: none;" class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> Image not found
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-image"></i> No image uploaded
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button wire:click="showEdit({{ $product->id }})" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button wire:click="backToList" class="btn btn-secondary">
                        <i class="bi bi-list"></i> Back to List
                    </button>
                </div>
            </div>
        </div>
    @endif
    
</div>
