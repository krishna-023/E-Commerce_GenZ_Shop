@extends('web.layouts.master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
    <div class="row">
        <div class="col-md-7">
            <h4>Delivery Information</h4>
            <form action="{{ route('items.placeOrder') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="delivery_address" class="form-label">Delivery Address</label>
                    <textarea name="delivery_address" id="delivery_address" class="form-control" rows="3" required></textarea>
                </div>

                <h4>Payment Method</h4>
                <div class="mb-3">
                    <select name="payment_method" class="form-select" required>
                        <option value="" disabled selected>Select payment method</option>
                        <option value="cod">Cash on Delivery</option>
                        <option value="esewa">eSewa</option>
                        <option value="khalti">Khalti</option>
                        <option value="visa">Visa / MasterCard</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Place Order</button>
            </form>
        </div>

        <div class="col-md-5">
            <h4>Order Summary</h4>
            <ul class="list-group mb-3">
                @php $totalPrice = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $totalPrice += $item['price'] * $item['quantity']; @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <img src="{{ asset('storage/items/' . $item['image']) }}" alt="{{ $item['title'] }}" width="50">
                            {{ $item['title'] }} (x{{ $item['quantity'] }})
                        </div>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>${{ number_format($totalPrice, 2) }}</strong>
                </li>
            </ul>
        </div>
    </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
