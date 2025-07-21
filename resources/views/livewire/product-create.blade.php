<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">Add New Product</div>
            <div class="float-end">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit="save">
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
</div>