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
                    {{-- @dump($product->toArray()) --}}
                    <h5>Name: {{ $product->name }}</h5>
                    <p>Price: ${{ number_format($product->price, 2) }}</p>
                    <p>Category: {{ $product->category }}</p>
                    <p>Stock: {{ $product->stock }}</p>
                    <img src="{{ $product->image ?? asset('images/default-product-image.png') }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection