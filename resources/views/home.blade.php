@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Products</h1>
            <form action="">
                @csrf
                <div class="input-group mb-3" style="width: 400px;">
                    <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control" placeholder="Search products..." aria-label="Search products">
                    <button class="btn btn-outline-secondary" type="button">Search</button>
                </div>
            </form>
        </div>

        @if($products->isEmpty())
            <p>No products available.</p>
        @else
            @foreach ($products as $product)
                <div class="col-md-3 mb-3">
                    <a class="product-link text-decoration-none" href="{{ route('product.show', $product->id) }}">
                        <div class="card">
                            <img src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)) : asset('images/default-product-image.png') }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <span class="badge rounded-pill text-bg-primary mb-2">{{ $product->category }}</span>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">${{ $product->price }}</p>
                                {{-- <a href="#" class="btn btn-primary">Add to Cart</a>
                                <a href="#" class="btn btn-primary">View Details</a> --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="">
                {{ $products->links() }}
            </div>
        @endif

        </div>
    </div>
</div>
@endsection
