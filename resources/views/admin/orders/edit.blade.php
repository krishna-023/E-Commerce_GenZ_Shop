@extends('admin.layouts.master')

@section('title', 'Edit Order')

@section('content')
<div class="container py-4">
    <h3>Edit Order #{{ $order->id }}</h3>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Customer Info --}}
        <div class="mb-3">
            <label class="form-label"><strong>Customer Name:</strong></label>
            <input type="text" class="form-control" value="{{ $order->customer_name }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Customer Phone:</strong></label>
            <input type="text" class="form-control" value="{{ $order->customer_phone }}" disabled>
        </div>

        {{-- Delivery Address --}}
        <div class="mb-3">
            <label for="delivery_address" class="form-label">Delivery Address</label>
            <textarea name="delivery_address" id="delivery_address" class="form-control" rows="3" required>{{ old('delivery_address', $order->delivery_address) }}</textarea>
        </div>

        {{-- Order Status --}}
        <div class="mb-3">
            <label for="order_status" class="form-label">Order Status</label>
            <select name="order_status" id="order_status" class="form-select" required>
                <option value="pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $order->order_status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Payment Status --}}
        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-select" required>
                <option value="pending" {{ $order->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $order->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ $order->payment_status == 'Failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        {{-- Delivery Status --}}
        <div class="mb-3">
            <label for="delivery_status" class="form-label">Delivery Status</label>
            <select name="delivery_status" id="delivery_status" class="form-select" required>
                <option value="Pending" {{ $order->delivery_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Delivered" {{ $order->delivery_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="Cancelled" {{ $order->delivery_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="Shipped" {{ $order->delivery_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
            </select>
        </div>

        {{-- Delivery Date --}}
        <div class="mb-3">
            <label for="delivery_date" class="form-label">Delivery Date</label>
            <input type="datetime-local" name="delivery_date" id="delivery_date" class="form-control"
                value="{{ $order->delivery_date ? $order->delivery_date->format('Y-m-d\TH:i') : '' }}">
        </div>

        <button type="submit" class="btn btn-success">Update Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
