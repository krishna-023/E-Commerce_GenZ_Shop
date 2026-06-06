@extends('web.layouts.master')

@section('title', 'Cart Checkout')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">🛒 Checkout</h3>

    @if(!empty($cart) && count($cart) > 0)
    <div class="row">
        {{-- Items Table --}}
        <div class="col-md-8">
            <table class="table table-bordered align-middle" id="cartTable">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th width="120">Price</th>
                        <th width="100">Qty</th>
                        <th width="120">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php
                            $finalPrice = $item['final_price'] ?? ($item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100));
                            $quantity = $item['quantity'];
                            $itemSubtotal = $finalPrice * $quantity;
                            $subtotal += $itemSubtotal;
                        @endphp
                        <tr data-id="{{ $id }}">
                            <td>
                                <img src="{{ asset('storage/' . $item['image']) }}" width="50" class="me-2 rounded" alt="{{ $item['title'] }}">
                                {{ $item['title'] }}
                                @if(($item['discount_percentage'] ?? 0) > 0)
                                    <span class="badge bg-danger ms-2">{{ $item['discount_percentage'] }}% OFF</span>
                                @endif
                            </td>
                            <td>
                                Rs. {{ number_format($finalPrice,2) }}
                                <input type="hidden" class="item-price" value="{{ $finalPrice }}">
                            </td>
                            <td>{{ $quantity }}</td>
                            <td class="item-subtotal">Rs. {{ number_format($itemSubtotal,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Delivery & Customer Info --}}
        <div class="col-md-4">
            <form action="{{ route('cart.placeOrder') }}" method="POST">
                @csrf
                <div class="card p-3">
                    <h5>Delivery Options</h5>
                    @foreach($deliveryCharges as $type => $charge)
                        <div class="form-check">
                            <input class="form-check-input delivery-type" type="radio" name="delivery_option" value="{{ $type }}" id="delivery_{{ $type }}" {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="delivery_{{ $type }}">
                                {{ $type }} @if($charge>0) (+Rs. {{ number_format($charge,2) }}) @endif
                            </label>
                        </div>
                    @endforeach

                    <hr>
                    <h5>Order Summary</h5>
                    <p>Items Total: Rs. <span id="items_total">{{ number_format($subtotal,2) }}</span></p>
                    <p>Delivery Charge: Rs. <span id="delivery_charge">{{ number_format(current($deliveryCharges),2) }}</span></p>
                    <p class="fw-bold">Grand Total: Rs. <span id="grand_total">{{ number_format($subtotal + current($deliveryCharges),2) }}</span></p>

                    {{-- Customer Details --}}
                    <div class="mt-3">
                        <label>Name</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required>
                    </div>
                    <div class="mt-3">
                        <label>Phone</label>
                        <input type="text" name="customer_phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" required>
                    </div>

                    {{-- Saved Addresses --}}
                    @if(!empty($addresses))
                        <div class="mt-3">
                            <label>Delivery Address</label>
                            <select name="customer_address" class="form-select">
                                @foreach($addresses as $address)
                                    <option value="{{ $address['address'] }}" {{ ($address['is_default'] ?? false) ? 'selected' : '' }}>
                                        {{ $address['label'] ?? 'Address' }} - {{ $address['address'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Or enter a new address below</small>
                        </div>
                    @endif

                    {{-- New Address --}}
                    <div class="mt-3">
                        <label>New Address</label>
                        <input type="text" name="customer_address_new" class="form-control" placeholder="Enter new address if not in saved addresses">
                        <div class="form-check mt-1">
                            <input type="checkbox" name="is_default" value="1" class="form-check-input" id="defaultAddress">
                            <label class="form-check-label" for="defaultAddress">Set as Default</label>
                        </div>
                    </div>

                    {{-- Delivery Date --}}
                    <div class="mt-3">
                        <label>Preferred Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" value="{{ old('delivery_date') }}">
                    </div>

                    {{-- Payment Method --}}
                    <div class="mt-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-4">
                        <h4>Total: Rs. <span id="total_display">{{ number_format($subtotal + current($deliveryCharges),2) }}</span></h4>
                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
        <p>Your cart is empty. <a href="{{ route('home') }}">Shop now!</a></p>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryRadios = document.querySelectorAll('.delivery-type');
    const itemsTotal = parseFloat('{{ $subtotal }}');
    const deliveryChargeEl = document.getElementById('delivery_charge');
    const grandTotalEl = document.getElementById('grand_total');
    const totalDisplay = document.getElementById('total_display');

    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const charges = @json($deliveryCharges);
            const charge = charges[this.value] || 0;
            deliveryChargeEl.textContent = charge.toFixed(2);
            grandTotalEl.textContent = (itemsTotal + charge).toFixed(2);
            totalDisplay.textContent = (itemsTotal + charge).toFixed(2);
        });
    });
});
</script>
@endsection
