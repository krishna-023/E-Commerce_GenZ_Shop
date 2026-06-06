@extends('web.layouts.master')

@section('title', 'Pay with eSewa')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Pay with eSewa</h3>

    <div class="card p-4 text-center">
        <h5>Order #{{ $order->id }}</h5>
        <p>Total Amount: <strong>Rs. {{ number_format($order->total, 2) }}</strong></p>

        @php
            $merchantCode = env('ESEWA_MERCHANT_CODE'); // Your eSewa Merchant Code
            $callbackUrl  = route('order.success', $order->id);
            $failUrl      = route('order.fail', $order->id);

            $esewaParams = [
                'amt'   => $order->total,
                'psc'   => 0,
                'pdc'   => 0,
                'tAmt'  => $order->total,
                'txAmt' => 0,
                'pid'   => $order->id,
                'scd'   => $merchantCode,
                'su'    => $callbackUrl,
                'fu'    => $failUrl
            ];

            $esewaUrl = 'https://uat.esewa.com.np/epay/main?' . http_build_query($esewaParams);
        @endphp

        @if($merchantCode)
            <p>Scan the QR code below using the eSewa app to complete your payment:</p>
            <div class="my-3">
                {!! QrCode::size(250)->generate($esewaUrl) !!}
            </div>

            <p>Or <a href="{{ $esewaUrl }}" target="_blank">click here to pay via browser</a></p>
        @else
            <p class="text-danger">
                eSewa merchant code is not configured. Please contact the site admin.
            </p>
        @endif

        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to Home</a>
    </div>
</div>
@endsection
