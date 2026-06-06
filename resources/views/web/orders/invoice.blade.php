@extends('web.layouts.master')

@section('title', 'Invoice')

@section('content')
<div class="container py-5">
    <div class="card p-4 shadow" id="invoice" style="max-width: 900px; margin:auto; border-radius:10px; border:1px solid #ddd; font-family: 'Arial', sans-serif;">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <img src="{{ asset('web/images/Logo.jpg') }}" alt="Logo" style="height: 60px;">
                <h3 class="mt-2" style="color:#333;">Genz Shop</h3>
                <p class="mb-0" style="color:#555;">Rajbiraj, Saptari, Nepal</p>
                <p class="mb-0" style="color:#555;">Phone: 9814734873 | Email: info@genzshop.com</p>
            </div>
            <div class="text-end">
                <h4 style="color:#333;">Invoice</h4>
                <p class="mb-0"><strong>#{{ $order->id }}</strong></p>
                <p class="mb-0">Date: {{ $order->order_date->format('d M, Y H:i') }}</p>
            </div>
        </div>

        <hr style="border-top: 2px dashed #ccc;">

        {{-- Customer & Delivery Details --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 style="color:#333;">Bill To:</h5>
                <p class="mb-1"><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            </div>
            <div class="col-md-6">
                <h5 style="color:#333;">Delivery Address:</h5>
                <p class="mb-1">{{ $order->delivery_address }}</p>
                @if($order->latitude && $order->longitude)
    <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}"
       target="_blank"
       class="btn btn-sm btn-outline-primary">
       📍 View on Map
    </a>
@endif
                <p class="mb-1"><strong>Delivery Option:</strong> {{ $order->delivery_option ?? 'Normal' }}</p>
                <p class="mb-1"><strong>Delivery Charges:</strong> Rs. {{ number_format($order->delivery_charge ?? 0, 2) }}</p>
            </div>
                        <div class="col-md-6">
            <h5>Delivery Information</h5>
<p><strong>Delivery Status:</strong> {{ $order->delivery_status ?? 'Pending' }}</p>
<p><strong>Delivery Date:</strong> {{ $order->delivery_date?->format('d M, Y H:i') ?? 'Not Delivered Yet' }}</p>
                        </div>
        </div>

        {{-- Order Items --}}
        <div class="mb-4">
            <h5 style="color:#333;">Order Items</h5>
            <table class="table table-striped table-bordered" style="border:1px solid #ccc;">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th class="text-end">Original Price</th>
                        <th class="text-end">Discount %</th>
                        <th class="text-end">Discount Amount</th>
                        <th class="text-end">Price After Discount</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @php $itemsTotal = 0; @endphp
@foreach($order->items as $index => $orderItem)
    @php
        $originalPrice = $orderItem->price; // original item price from order
        $discountPercentage = $orderItem->item->discount_percentage ?? 0; // from Item
        $discountAmount = ($originalPrice * $discountPercentage) / 100;
        $finalPrice = $originalPrice - $discountAmount;
        $subtotal = $finalPrice * $orderItem->quantity;
        $itemsTotal += $subtotal;
    @endphp
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $orderItem->item->title }}</td>
        <td class="text-end">Rs. {{ number_format($originalPrice, 2) }}</td>
        <td class="text-end">{{ $discountPercentage }}%</td>
        <td class="text-end">Rs. {{ number_format($discountAmount, 2) }}</td>
        <td class="text-end">Rs. {{ number_format($finalPrice, 2) }}</td>
        <td class="text-center">{{ $orderItem->quantity }}</td>
        <td class="text-end">Rs. {{ number_format($subtotal, 2) }}</td>
    </tr>
@endforeach

                </tbody>
                <tfoot>
    <tr>
        <td colspan="7" class="text-end"><strong>Items Total:</strong></td>
        <td class="text-end">Rs. {{ number_format($itemsTotal, 2) }}</td>
    </tr>
    <tr>
        <td colspan="7" class="text-end"><strong>Delivery Charges:</strong></td>
        <td class="text-end">Rs. {{ number_format($order->delivery_charge ?? 0, 2) }}</td>
    </tr>
    <tr>
        <td colspan="7" class="text-end"><strong>Grand Total:</strong></td>
        <td class="text-end"><strong>Rs. {{ number_format($itemsTotal + ($order->delivery_charge ?? 0), 2) }}</strong></td>
    </tr>
</tfoot>

            </table>
        </div>

        {{-- Payment & Order Status --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong>
                    @if(strtolower($order->payment_status) === 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif(strtolower($order->payment_status) === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif(strtolower($order->payment_status) === 'failed')
                        <span class="badge bg-danger">Failed</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Order Status:</strong>
                    @if(strtolower($order->order_status) === 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif(strtolower($order->order_status) === 'confirmed')
                        <span class="badge bg-success">Confirmed</span>
                    @elseif(strtolower($order->order_status) === 'cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-4">
            <p style="color:#555;">Thank you for shopping with Genz Shop!</p>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
            <button class="btn btn-success" onclick="printInvoice()">Print Invoice</button>
        </div>
    </div>
</div>

<script>
function printInvoice() {
    let printContents = document.getElementById('invoice').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

<style>
@media print {
    body * { visibility: hidden; }
    #invoice, #invoice * { visibility: visible; }
    #invoice { position: absolute; left:0; top:0; width:100%; }
    .btn { display:none !important; }
}
</style>
@endsection
