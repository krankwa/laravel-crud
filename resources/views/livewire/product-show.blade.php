
<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">Product Details</div>
            <div class="float-end">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
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
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="bi bi-list"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>