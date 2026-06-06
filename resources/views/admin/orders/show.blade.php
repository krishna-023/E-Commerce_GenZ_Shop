@extends('admin.layouts.master')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <h3>Order #{{ $order->id }}</h3>
    <p><strong>Customer:</strong> {{ $order->customer->name ?? 'Guest' }}</p>
    <p><strong>Total Price:</strong> Rs. {{ $order->total_price }}</p>
    <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
    <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
    <p><strong>Order Date:</strong> {{ $order->order_date->format('d M, Y H:i') }}</p>

    <h5 class="mt-4">Items</h5>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->item->title ?? 'N/A' }} x {{ $item->quantity }} = Rs. {{ $item->price }}</li>
        @endforeach
    </ul>

    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning mt-3">Edit Order</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection
