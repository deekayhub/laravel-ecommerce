@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Product Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                         <div class="col-md-6">
                            <img src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)) : asset('images/default-product-image.png') }}" alt="{{ $product->name }}" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h5>Name: {{ $product->name }}</h5>
                            <p>Description: {{ $product->description }}</p>
                            <p>Price: ${{ number_format($product->price, 2) }}</p>
                            <p>Category: {{ $product->category }}</p>
                            <p>Stock: {{ $product->stock }}</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
