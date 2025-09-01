@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1>My Orders</h1>
            <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No orders available.</td>
                                    </tr>
                                @else
                                    @foreach($orders as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>
                                        <img src="{{ $item->image ? (filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('storage/' . $item->image)) : asset('images/default-product-image.png') }}"
                                            alt="{{ $item->name }}"
                                            width="50"
                                            height="50"
                                            class="img-thumbnail">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>${{ number_format($item->total_amount, 2) }}</td>
                                        <td>{{ str($item->status)->ucfirst() }}</td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
        </div>
    </div>
</div>

@endsection
