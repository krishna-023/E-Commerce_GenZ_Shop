@extends('admin.layouts.master')

@section('title', 'Orders')

@section('content')
<div class="container-fluid py-4">
    <h3 class="mb-4">Orders</h3>

    {{-- Filter Form --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="seller_name" class="form-control" placeholder="Search by Item Seller" value="{{ request('seller_name') }}">
        </div>
        <div class="col-md-2">
            <select name="order_status" class="form-select">
                <option value="">All Status</option>
                <option value="Pending" {{ request('order_status')=='Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ request('order_status')=='Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Completed" {{ request('order_status')=='Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ request('order_status')=='Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="payment_status" class="form-select">
                <option value="">All Payments</option>
                <option value="Pending" {{ request('payment_status')=='Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ request('payment_status')=='Paid' ? 'selected' : '' }}>Paid</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter Orders</button>
        </div>
    </form>

    {{-- Orders Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Items / Sellers</th>
                    <th>Order Status</th>
                    <th>Payment Status</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        <ul>
                            @foreach($order->items as $orderItem)
                                <li>
                                    {{ $orderItem->item->title ?? 'Item Deleted' }}
                                    <br>
                                    <small class="text-muted">Seller: {{ $orderItem->item->seller->name ?? 'N/A' }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->order_status }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>Rs. {{ number_format($order->total,2) }}</td>
                    <td>{{ $order->order_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <a href="{{ route('orders.destroy', $order->id) }}" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
