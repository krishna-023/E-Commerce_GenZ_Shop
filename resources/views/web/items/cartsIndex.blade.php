@extends('web.layouts.master')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Your Shopping Cart</h3>

    @if($cart && count($cart) > 0)
        {{-- Filter & Sort Form --}}
        <form method="GET" class="row mb-3 g-2">
            <div class="col-md-3">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" placeholder="From Date">
            </div>
            <div class="col-md-3">
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" placeholder="To Date">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
            </div>
        </form>

        {{-- Select & Checkout Form --}}
        <form action="{{ route('cart.checkoutSelected') }}" method="POST">
            @csrf
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Select</th>
                        <th>Item</th>
                        <th width="120">Price</th>
                        <th width="100">Quantity</th>
                        <th width="120">Subtotal</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php
                            $discount = $item['discount_percentage'] ?? 0;
                            $finalPrice = $item['price'] - ($item['price'] * $discount / 100);
                            $quantity = $item['quantity'];
                            $subtotal = $finalPrice * $quantity;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="{{ $id }}" checked>
                                <input type="hidden" name="quantities[{{ $id }}]" value="{{ $quantity }}">
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $item['image']) }}" width="50" class="me-2 rounded" alt="{{ $item['title'] }}">
                                {{ $item['title'] }}
                                @if($discount > 0)
                                    <span class="badge bg-danger ms-2">{{ $discount }}% OFF</span>
                                @endif
                            </td>
                            <td>
                                <h5 class="text-danger mb-0">
                                    Rs. {{ number_format($finalPrice, 2) }}
                                    @if($discount > 0)
                                        <small class="text-muted"><del>Rs. {{ number_format($item['price'], 2) }}</del></small>
                                    @endif
                                </h5>
                            </td>
                            <td>
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $quantity }}" min="1" style="width:60px">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>Rs. {{ number_format($subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">Rs. {{ number_format($total, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('home') }}" class="btn btn-secondary">Continue Shopping</a>
                <button type="submit" class="btn btn-success">Checkout Selected Items</button>
            </div>
        </form>

    @else
        <p>Your cart is empty. <a href="{{ route('home') }}">Shop now!</a></p>
    @endif
</div>
@endsection
