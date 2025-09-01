@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <span>Admin Dashboard</span>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary float-end">View all products</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No products available.</td>
                                    </tr>
                                @else
                                    @foreach($products as $product)
                                    <tr>
                                        <th scope="row">{{ $product->id }}</th>
                                        <td>
                                        <img
                                                src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image)) : asset('images/default-product-image.png') }}"
                                                alt="{{ $product->name }}"
                                                width="50"
                                                height="50"
                                                class="img-thumbnail">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <span>Orders</span>
                    <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary float-end">View all orders</a>
                </div>
                <div class="card-body">                   

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Registered At</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No customers available.</td>
                                    </tr>
                                @else
                                    @foreach($orders as $customer)
                                    <tr>
                                        <th scope="row">{{ $customer->id }}</th>                                      
                                        <td>${{ $customer->name }}</td>
                                        <td>{{ $customer->shipping_address }}</td>
                                        <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $customer->status }}</td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
