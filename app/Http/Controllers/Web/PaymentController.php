<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Show eSewa Payment page with QR
    public function pay(Order $order)
    {
        $merchant_code = env('ESEWA_MERCHANT_CODE');
        $callbackUrl = route('order.success', $order->id);
        $failUrl = route('order.fail', $order->id);

        return view('payment_esewa', compact('order', 'merchant_code', 'callbackUrl', 'failUrl'));
    }

    // Webhook called by eSewa for real-time confirmation
    public function webhook(Request $request)
    {
        $payload = $request->all();

        $order = Order::find($payload['pid'] ?? null);

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Verify eSewa payment (you can call eSewa verification API here)
        $verified = $payload['status'] === 'success'; // Example

        Payment::create([
            'order_id' => $order->id,
            'gateway' => 'eSewa',
            'transaction_id' => $payload['refId'] ?? null,
            'amount' => $order->total,
            'status' => $verified ? 'paid' : 'failed',
            'payload' => $payload
        ]);

        $order->update([
            'payment_status' => $verified ? 'Paid' : 'Failed',
            'order_status' => $verified ? 'Confirmed' : 'Pending',
        ]);

        return response()->json(['status' => 'ok']);
    }

    // Success redirect after payment
    public function success(Order $order)
    {
        return redirect()->route('user.orders')
            ->with('success', 'Payment successful! Your order is confirmed.');
    }

    // Fail redirect after payment
    public function cancel(Order $order)
    {
        return redirect()->route('user.orders')
            ->with('error', 'Payment failed or cancelled.');
    }
    // Show FonePay QR page
    public function fonepayPayment(Order $order)
    {

        // Make sure user owns this order
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        // FonePay callback URLs
        $callbackUrl = route('payment.fonepay.success', $order->id);
        $failUrl     = route('payment.fonepay.fail', $order->id);

        // FonePay QR Data
        $fonepayData = [
            'amount'   => $order->total,
            'order_id' => $order->id,
            'callback' => $callbackUrl,
        ];

        return view('payment_fonepay', compact('order', 'fonepayData', 'callbackUrl', 'failUrl'));
    }

    // Callback: Payment Success
    public function fonepaySuccess(Request $request, Order $order)
{
    if ($order->customer_id !== Auth::id()) abort(403);

    // Retrieve the transaction ID from the request
    $transactionId = $request->input('transaction_id');

    // Define the sandbox verification URL
    $verifyUrl = 'https://sandbox.fonepay.com.np/api/v1/verify';

    // Send a POST request to verify the payment
    $response = Http::post($verifyUrl, [
        'order_id' => $order->id,
        'transaction_id' => $transactionId,
        'merchant_id' => env('FONEPAY_MERCHANT_ID'),
        'merchant_key' => env('FONEPAY_MERCHANT_KEY'),
    ]);

    // Check if the response is successful and the payment status is 'success'
    if ($response->successful() && $response->json('status') == 'success') {
        // Update the order statuses accordingly
        $order->update([
            'payment_status' => 'Paid',
            'order_status' => 'Confirmed',
            'delivery_status' => 'Processing',
        ]);

        // Redirect the user with a success message
        return redirect()->route('home')->with('success', 'Payment successful! Your order is confirmed.');
    }

    // Handle the case where the payment verification fails
    return redirect()->route('home')->with('error', 'Payment verification failed. Please contact support.');
}


    // Callback: Payment Failed
    public function fonepayFail(Order $order)
    {
        if ($order->customer_id !== Auth::id()) abort(403);

        $order->update(['payment_status' => 'Failed']);

        return redirect()->route('home')->with('error', 'Payment failed. Please try again.');
    }
}
