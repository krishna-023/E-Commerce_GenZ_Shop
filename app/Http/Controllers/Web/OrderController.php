<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
  public function index(Request $request)
{
    $query = Order::with(['seller', 'items.item']); // eager load items and their seller

    // Filter by order_status
    if ($request->filled('order_status')) {
        $query->where('order_status', $request->order_status);
    }

    // Filter by payment_status
    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    // Filter by seller of the items
    if ($request->filled('seller_name')) {
        $sellerName = $request->seller_name;
        $query->whereHas('items.item', function($q) use ($sellerName) {
    $q->whereHas('sellers', function($q2) use ($sellerName) {
        $q2->where('seller_name', 'like', "%{$sellerName}%");
    });
});

    }

    // Filter by exact date
    if ($request->filled('date')) {
        $query->whereDate('order_date', $request->date);
    }

    $orders = $query->latest()->paginate(10);

    return view('admin.orders.index', compact('orders'));
}

    // =======================
    // BUY NOW: Single Item
    // =======================
    // Buy Now checkout (single item)
  public function buyNowCheckout(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $quantity = $request->input('quantity', 1);

        $finalPrice = $item->price - ($item->price * ($item->discount_percentage ?? 0) / 100);
        $subtotal = $finalPrice * $quantity;

        $cart = [
            $item->id => [
                'title' => $item->title,
                'price' => $item->price,
                'discount_percentage' => $item->discount_percentage ?? 0,
                'quantity' => $quantity,
                'image' => $item->image,
                'final_price' => $finalPrice,
                'subtotal' => $subtotal,
            ]
        ];

        $deliveryCharges = [
            'Normal' => 0,
            'Express' => 100,
        ];

        $initialTotal = $subtotal;

        $addresses = Auth::user()->addresses ?? [];

        return view('web.checkout_buynow', compact(
            'cart', 'deliveryCharges', 'itemId', 'initialTotal', 'addresses'
        ));
    }

    // ======================
    // PLACE BUY NOW ORDER
    // ======================
  public function buyNowPlaceOrder(Request $request, $itemId)
{
    $request->validate([
        'customer_name'   => 'required|string|max:255',
        'customer_phone'  => 'required|string|max:20',
        'delivery_option' => 'required|string',
        'payment_method'  => 'required|string',
        'gateway'         => 'required_if:payment_method,Online Payment|string|in:esewa,fonepay',
        'latitude'  => 'nullable|numeric',
    'longitude' => 'nullable|numeric',
    ]);

    $item = Item::findOrFail($itemId);
    $quantity = $request->input('quantity', 1);

$deliveryAddress = null;

// Priority 1: Current Location Address (auto-filled)
if (!empty($request->customer_address_new)) {
    $deliveryAddress = $request->customer_address_new;
}

// Priority 2: Saved Address
elseif (!empty($request->customer_address)) {
    $deliveryAddress = $request->customer_address;
}

// Fallback (safety)
else {
    $deliveryAddress = 'Location not specified';
}

    $deliveryCharges = [
        'Standard' => 50,
        'Express'  => 100,
        'Free'     => 0,
    ];

    $deliveryCharge = $deliveryCharges[$request->delivery_option] ?? 0;

    $subtotal = $item->price * $quantity;
    $total = $subtotal + $deliveryCharge;

    // Create the Order
    $order = Order::create([
        'customer_id'      => Auth::id(),
        'customer_name'    => $request->customer_name,
        'customer_phone'   => $request->customer_phone,
        'delivery_address' => $deliveryAddress,
         'latitude'         => $request->latitude,
    'longitude'        => $request->longitude,
        'delivery_option'  => $request->delivery_option,
        'delivery_charge'  => $deliveryCharge,
        'delivery_date'    => $request->delivery_date,
        'delivery_status'  => 'Pending',
        'payment_method'   => $request->payment_method,
        'payment_status'   => $request->payment_method === 'Cash On Delivery' ? 'Pending' : 'Initiated',
        'total'            => $total,
        'order_status'     => $request->payment_method === 'Cash On Delivery' ? 'Pending' : 'Processing',
        'seller_id'        => $item->sellers()->first()->id ?? null,
    ]);

    $order->items()->create([
        'item_id' => $item->id,
        'quantity' => $quantity,
        'price' => $item->price,
        'subtotal' => $subtotal,
    ]);

    // Cash on Delivery
    if($request->payment_method === 'Cash On Delivery'){
        return redirect()->route('items.invoice', $order->id)
                         ->with('success', 'Your order has been placed successfully!');
    }

    // Online Payment
    $gateway = $request->gateway;

    if($gateway === 'esewa'){
        $callbackUrl = route('payment.success', $order->id);
        $failUrl = route('payment.fail', $order->id);
        $merchant_code = env('ESEWA_MERCHANT_CODE');

        $esewaData = [
            'amt' => $order->total,
            'psc' => 0,
            'pdc' => 0,
            'tamt' => $order->total,
            'txAmt' => 0,
            'pid' => $order->id,
            'scd' => $merchant_code,
            'su' => $callbackUrl,
            'fu' => $failUrl
        ];

        $esewaUrl = 'https://esewa.com.np/epay/main?' . http_build_query($esewaData);

        return view('payment_esewa', compact('order', 'esewaUrl', 'merchant_code', 'callbackUrl', 'failUrl'));
    }

    if($gateway === 'fonepay'){
        $callbackUrl = route('payment.fonepay.success', $order->id);
        $failUrl     = route('payment.fonepay.fail', $order->id);

        $fonepayData = [
            'amt'      => $order->total,
            'pid'      => $order->id,
            'su'       => $callbackUrl,
            'fu'       => $failUrl,
        ];

        return view('payment_fonepay', compact('order', 'fonepayData', 'callbackUrl', 'failUrl'));
    }

    return redirect()->back()->with('error', 'Invalid payment gateway selected.');
}


   public function userOrders()
{
    $orders = Order::with('items.item')
                   ->where('customer_id', Auth::id())
                   ->latest()
                   ->get();

    return view('web.user.orders', compact('orders'));
}

// =======================
// INVOICE FOR USER
// =======================
public function invoice($orderId)
{
    // Load the order with its items and each item details
    $order = Order::with(['items.item'])->findOrFail($orderId);

    // Check if the logged-in user owns the order
    if ($order->customer_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // Do NOT update delivery_status here — keep it as is
    // Delivery date will only change via markAsDelivered() or cancelOrder()

    return view('web.orders.invoice', compact('order'));
}

public function markAsDelivered(Order $order)
{
    $order->update([
        'delivery_status' => 'Delivered',
        'delivery_date' => now(),
    ]);

    return redirect()->back()->with('success', 'Order marked as delivered.');
}


// =======================
// CANCEL ORDER (AJAX)
// =======================
public function cancelOrder(Order $order)
{
    if ($order->customer_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }

    if ($order->order_status !== 'Pending') {
        return response()->json(['error' => 'Only pending orders can be cancelled.'], 400);
    }

    $order->update([
        'order_status' => 'Cancelled',
        'delivery_status' => 'Cancelled',  // <-- update delivery_status
        'delivery_date' => now(),          // <-- timestamp when cancelled
    ]);

    return response()->json(['success' => 'Order cancelled successfully.']);
}

    // =======================
    // eSewa Payment Success
    // =======================
     public function paymentSuccess(Order $order, Request $request)
    {
        $esewaMerchantCode = env('ESEWA_MERCHANT_CODE');

        // eSewa verification endpoint
        $verificationUrl = 'https://uat.esewa.com.np/epay/transrec';

        // Parameters to verify payment
        $response = Http::asForm()->post($verificationUrl, [
            'amt'   => $order->total,
            'scd'   => $esewaMerchantCode,
            'pid'   => $order->id,
            'rid'   => $request->input('refId'), // eSewa reference ID
        ]);

        if (trim($response->body()) === 'Success') {
            $order->update([
                'payment_status' => 'Paid',
                'order_status'   => 'Confirmed',
                'delivery_status'=> 'Processing',
            ]);

            return redirect()->route('home')->with('success', 'Payment successful! Your order is confirmed.');
        }

        return redirect()->route('home')->with('error', 'Payment verification failed. Please contact support.');
    }

    // =======================
    // eSewa Payment Failure Callback
    // =======================
    public function paymentFail(Order $order)
    {
        $order->update(['payment_status' => 'Failed']);
        return redirect()->route('home')->with('error', 'Payment failed. Please try again.');
    }
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
{
    $request->validate([
        'order_status'    => 'required|in:pending,confirmed,cancelled',
        'payment_status'  => 'required|in:pending,paid,failed',
        'delivery_status' => 'required|in:Pending,Delivered,Cancelled,Shipped',
        'delivery_address'=> 'required|string|max:500',
        'delivery_date'   => 'nullable|date',
    ]);

    $data = $request->only('order_status', 'payment_status', 'delivery_status', 'delivery_address', 'delivery_date');

    // Automatically set delivery_date if status changed to Delivered or Cancelled
    if(in_array($data['delivery_status'], ['Delivered', 'Cancelled']) && empty($data['delivery_date'])){
        $data['delivery_date'] = now();
    }

    $order->update($data);

    return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
}


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}

 // Place Order and redirect to eSewa
//    public function CartplaceOrder(Request $request)
// {
//     $request->validate([
//         'delivery_address' => 'required|string|max:500',
//     ]);

//     $cart = session()->get('cart', []);
//     if (!$cart) {
//         return redirect()->back()->with('error', 'Your cart is empty!');
//     }

//     $totalPrice = 0;
//     foreach ($cart as $item) {
//         $totalPrice += $item['price'] * $item['quantity'];
//     }

//     // Create order
//     $order = Order::create([
//         'customer_id' => Auth::id(),
//         'total_price' => $totalPrice,
//         'delivery_address' => $request->delivery_address,
//         'order_status' => 'pending',
//         'payment_status' => 'pending',
//         'payment_method' => 'esewa',
//         'order_date' => now(),
//     ]);

//     // Create order items
//     foreach ($cart as $item) {
//         $order->items()->create([
//             'item_id' => $item['id'],
//             'quantity' => $item['quantity'],
//             'price' => $item['price'],
//         ]);
//     }

//     session()->put('order_id', $order->id); // optional

//     // Redirect to eSewa payment page
//     $esewa_url = 'https://uat.esewa.com.np/epay/main';
//     $merchant_code = env('ESEWA_MERCHANT_CODE');

//     return view('payment_esewa', compact('order', 'esewa_url', 'merchant_code'));
// }
