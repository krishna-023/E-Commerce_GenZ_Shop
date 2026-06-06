@extends('web.layouts.master')

@section('title', 'FonePay Payment')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">🛒 FonePay Payment</h3>

    <p>Scan the QR code below with your FonePay app to pay Rs. {{ number_format($order->total, 2) }}.</p>

    <div class="text-center my-3">
        {!! QrCode::size(250)->generate(
            'https://sandbox.fonepay.com.np/pay?' . http_build_query([
                'amt' => $order->total,
                'pid' => $order->id,
                'su'  => $callbackUrl,
                'fu'  => $failUrl,
            ])
        ) !!}
    </div>

    <p class="text-center mt-3">
        After completing payment, you will be redirected automatically. <br>
        If not, <a href="{{ $callbackUrl }}">click here</a>.
    </p>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel & Return Home</a>
    </div>
</div>
@endsection
