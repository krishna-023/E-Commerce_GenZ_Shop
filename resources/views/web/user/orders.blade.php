@extends('web.layouts.master')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">My Orders</h3>

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Delivery Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr id="order-{{ $order->id }}">
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->order_date->format('d M, Y H:i') }}</td>
                            <td>Rs. {{ number_format($order->total, 2) }}</td>

                            {{-- Order Status --}}
                            <td>
                                @php
                                    $orderStatusClass = 'bg-secondary';
                                    if ($order->order_status == 'Pending') $orderStatusClass = 'bg-warning';
                                    elseif ($order->order_status == 'Confirmed') $orderStatusClass = 'bg-success';
                                    elseif ($order->order_status == 'Cancelled') $orderStatusClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $orderStatusClass }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>

                            {{-- Payment Status --}}
                            <td>
                                @php
                                    $paymentStatusClass = 'bg-secondary';
                                    if ($order->payment_status == 'Pending') $paymentStatusClass = 'bg-warning';
                                    elseif ($order->payment_status == 'Paid') $paymentStatusClass = 'bg-success';
                                    elseif ($order->payment_status == 'Failed') $paymentStatusClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $paymentStatusClass }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>

                            {{-- Delivery Status --}}
                            <td>
                                @php
                                    $deliveryStatusClass = 'bg-secondary';
                                    if ($order->delivery_status == 'Pending') $deliveryStatusClass = 'bg-warning';
                                    elseif ($order->delivery_status == 'Delivered') $deliveryStatusClass = 'bg-success';
                                    elseif ($order->delivery_status == 'Shipped') $deliveryStatusClass = 'bg-info';
                                    elseif ($order->delivery_status == 'Cancelled') $deliveryStatusClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $deliveryStatusClass }}">
                                    {{ $order->delivery_status }}
                                </span>
                            </td>

                            <td>
                                {{ $order->delivery_date?->format('d M, Y H:i') ?? 'Not Delivered Yet' }}
                            </td>

                            <td class="d-flex flex-column gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info text-white">View Details</a>
                                <a href="{{ route('items.invoice', $order->id) }}" class="btn btn-sm btn-primary">View Invoice</a>

                                @if($order->order_status == 'Pending')
                                    <button class="btn btn-sm btn-danger cancel-order" data-id="{{ $order->id }}">Cancel</button>
                                @endif
                            </td>
                        </tr>

                        {{-- Show order items --}}
                        <tr class="order-items-row">
                            <td colspan="8">
                                <strong>Items:</strong>
                                <ul class="list-unstyled mb-2">
                                    @foreach($order->items as $item)
                                        <li>
                                            {{ $item->item->title }} (x{{ $item->quantity }}) - Rs. {{ number_format($item->price, 2) }}
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Show payment history --}}
                                <strong>Payment History:</strong>
                                @if($order->payments->count() > 0)
                                    <table class="table table-sm table-bordered mt-2">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Gateway</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Transaction ID</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->payments as $payment)
                                                @php
                                                    $paymentClass = 'bg-secondary';
                                                    if ($payment->status == 'Pending') $paymentClass = 'bg-warning';
                                                    elseif ($payment->status == 'Paid') $paymentClass = 'bg-success';
                                                    elseif ($payment->status == 'Failed') $paymentClass = 'bg-danger';
                                                    elseif ($payment->status == 'Refunded') $paymentClass = 'bg-secondary';
                                                @endphp
                                                <tr>
                                                    <td>{{ strtoupper($payment->gateway) }}</td>
                                                    <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                                                    <td><span class="badge {{ $paymentClass }}">{{ $payment->status }}</span></td>
                                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                                    <td>{{ $payment->created_at->format('d M, Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted mb-0">No payment records found.</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center">You have no orders yet. <a href="{{ route('home') }}">Start Shopping</a></p>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.cancel-order');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.id;
            if(confirm('Are you sure you want to cancel this order?')) {
                fetch(`/my-orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        alert(data.success);
                        const badge = document.querySelector(`#order-${orderId} td:nth-child(4) span`);
                        badge.textContent = 'Cancelled';
                        badge.className = 'badge bg-danger';
                        const deliveryBadge = document.querySelector(`#order-${orderId} td:nth-child(6) span`);
                        deliveryBadge.textContent = 'Cancelled';
                        deliveryBadge.className = 'badge bg-danger';
                        const deliveryDateCell = document.querySelector(`#order-${orderId} td:nth-child(7)`);
                        const now = new Date();
                        deliveryDateCell.textContent = now.toLocaleString();
                        this.remove();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(err => console.error(err));
            }
        });
    });
});
</script>
@endsection
