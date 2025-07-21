
<div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
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
            
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2">
                <i class="bi bi-plus-circle"></i> Add New Product
            </a>
            
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
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Show
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <button wire:click="delete({{ $product->id }})" 
                                    wire:confirm="Are you sure you want to delete this product?"
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
</div>