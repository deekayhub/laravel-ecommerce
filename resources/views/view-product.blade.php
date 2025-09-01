@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img class="img-fluid img-thumbnail" src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)) : asset('images/default-product-image.png') }}" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1 class="mb-4">{{ $product->name }}</h1>
            <p class="card-text">${{ $product->price }}</p>
            <p class="card-text">{{ $product->description }}</p>
            <a href="{{ route('place.order', ['id' => $product->id]) }}" class="btn btn-primary">Order Now</a>
        </div>
    </div>
</div>
@endsection
