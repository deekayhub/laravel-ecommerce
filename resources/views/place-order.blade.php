@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Place Order : #{{ $product->name }}</h1>

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

    <form method="POST" action="{{ route('place.order.submit', ['id' => $product->id]) }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" value="{{ Auth::user()->name ?? '' }}" class="form-control" id="name" readonly>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" value="{{ Auth::user()->email ?? '' }}" class="form-control" id="email" readonly>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}" class="form-control" id="phone" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" value="{{ Auth::user()->address ?? '' }}" class="form-control" id="address">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <input type="text" name="notes" value="{{ Auth::user()->notes ?? '' }}" class="form-control" id="notes">
        </div>

        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
@endsection
