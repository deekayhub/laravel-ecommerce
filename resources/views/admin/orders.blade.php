@extends('layouts.app')
@section('content')

<div class="container">
    <h1>All Orders</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <span>Orders</span>
                    {{-- <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary float-end">View all products</a> --}}
                </div>
                <div class="card-body">                   

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($allOrders->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No customers available.</td>
                                    </tr>
                                @else
                                    @foreach($allOrders as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>                                      
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->user_name }}</td>
                                        <td>${{ $item->price }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                        <td>{{ str($item->status)->ucfirst() }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $item->id }}">
                                            View
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="orderModal{{ $item->id }}" tabindex="-1" aria-labelledby="orderModal{{ $item->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Order ID: {{ $item->id }}</h4>
                                                        <h4>Product Name: {{ $item->name }}</h4>
                                                        <form action="{{ route('admin.orders.update.status', $item->order_id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">Status:</label>
                                                                <select name="status" id="status" class="form-select">
                                                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                                </select>
                                                            </div>                                                        
                                                            <button type="submit" class="btn btn-primary text-end">Update</button>
                                                        </form>
                                                    </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                            </table>
                        </div>
                        {{ $allOrders->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection