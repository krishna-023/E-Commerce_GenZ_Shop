<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class CartController extends Controller
{
    // Show cart with optional sorting/filtering
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $cartCollection = collect($cart);

        // Price sorting
        if($request->sort == 'price_asc'){
            $cartCollection = $cartCollection->sortBy(fn($item) => $item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100));
        } elseif($request->sort == 'price_desc'){
            $cartCollection = $cartCollection->sortByDesc(fn($item) => $item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100));
        }

        // Date range filtering (if you store added_at)
        if($request->from_date){
            $cartCollection = $cartCollection->filter(fn($item) => isset($item['added_at']) && $item['added_at'] >= $request->from_date);
        }
        if($request->to_date){
            $cartCollection = $cartCollection->filter(fn($item) => isset($item['added_at']) && $item['added_at'] <= $request->to_date);
        }

        $cart = $cartCollection->toArray();
        return view('web.items.cartsIndex', compact('cart'));
    }

    public function add(Request $request, $id)
{
    $item = Item::findOrFail($id);
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    } else {
        $cart[$id] = [
            'id' => $item->id, // <-- add this
            'title' => $item->title,
            'price' => $item->price,
            'discount_percentage' => $item->discount_percentage ?? 0,
            'final_price' => $item->price - ($item->price * ($item->discount_percentage ?? 0) / 100),
            'quantity' => 1,
            'image' => $item->image,
            'added_at' => now()->format('Y-m-d'),
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Item added to cart!');
}


    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantity'] = $request->quantity;
            $cart[$id]['final_price'] = $cart[$id]['price'] - ($cart[$id]['price'] * ($cart[$id]['discount_percentage'] ?? 0) / 100);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

   public function checkoutSelected(Request $request)
{
    $selectedIds = $request->input('selected_items', []);
    $quantities = $request->input('quantities', []);
    $cart = session()->get('cart', []);

    $selectedCart = [];
    foreach($selectedIds as $id){
        if(isset($cart[$id])){
            $item = $cart[$id];
            $item['quantity'] = $quantities[$id] ?? $item['quantity'];
            $item['final_price'] = $item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100);
            $selectedCart[$id] = $item;
        }
    }

    if(empty($selectedCart)){
        return redirect()->back()->with('error', 'No items selected!');
    }

    $deliveryCharges = ['Express'=>100,'Normal'=>0];
    $addresses = Auth::check() ? Auth::user()->addresses ?? [] : [];

    // Calculate subtotal
    $subtotal = 0;
    foreach ($selectedCart as $item) {
        $subtotal += $item['final_price'] * $item['quantity'];
    }

    return view('web.checkout_cart', [
        'cart' => $selectedCart,
        'deliveryCharges' => $deliveryCharges,
        'addresses' => $addresses,
        'subtotal' => $subtotal
    ]);
}


    public function placeOrder(Request $request)
    {
    $request->validate([
        'customer_name'   => 'required|string|max:255',
        'customer_phone'  => 'required|string|max:20',
        'customer_address' => 'nullable|string|max:500',
        'customer_address_new' => 'nullable|string|max:500',
        'is_default' => 'nullable|boolean',
        'delivery_option' => 'required|string|in:Normal,Express',
        'payment_method' => 'required|string|in:Cash On Delivery,Online Payment',
        'delivery_date' => 'nullable|date|after_or_equal:today',
    ]);

    $cart = session()->get('cart', []);
    if (!$cart || count($cart) === 0) {
        return redirect()->back()->with('error', 'Your cart is empty!');
    }

    $deliveryCharges = [
        'Normal' => 0,
        'Express' => 100,
    ];

    // Determine which address to use
    $address = $request->customer_address_new ?: $request->customer_address;

    $subtotal = 0;

    foreach ($cart as $id => $item) {
        $quantity = $item['quantity'];
        $finalPrice = $item['final_price'] ?? ($item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100));
        $subtotal += $finalPrice * $quantity;
    }

    $total = $subtotal + ($deliveryCharges[$request->delivery_option] ?? 0);

    // Create order
    $order = Order::create([
        'customer_id'      => Auth::id(),
        'customer_name'    => $request->customer_name,
        'customer_phone'   => $request->customer_phone,
        'delivery_address' => $address,
        'delivery_option'  => $request->delivery_option,
        'delivery_charge'  => $deliveryCharges[$request->delivery_option],
        'payment_method'   => $request->payment_method,
        'order_date'       => now(),
        'order_status'     => 'Pending',
        'payment_status'   => 'Pending',
        'delivery_date'    => $request->delivery_date,
        'delivery_status'  => 'Pending',
        'total'            => $total,
    ]);

    // Save each cart item as OrderItem
    foreach ($cart as $id => $item) {
        $quantity = $item['quantity'];
        $discountPercentage = $item['discount_percentage'] ?? 0;
        $discountAmount = ($item['price'] * $discountPercentage) / 100;
        $finalPrice = $item['final_price'] ?? ($item['price'] - $discountAmount);

        OrderItem::create([
            'order_id'            => $order->id,
            'item_id'             => $item['id'],
            'quantity'            => $quantity,
            'price'               => $item['price'],
            'discount_percentage' => $discountPercentage,
            'discount_amount'     => $discountAmount,
            'final_price'         => $finalPrice,
        ]);
    }

    // Optionally save new address as default for the user
    if ($request->customer_address_new && $request->is_default) {
        $user = Auth::user();
        $userAddresses = $user->addresses ?? [];
        $userAddresses[] = [
            'label' => 'Home', // or you can ask for label input
            'address' => $request->customer_address_new,
            'is_default' => true
        ];
        $user->addresses = $userAddresses;
        $user->save();
    }

    // Clear cart session
    session()->forget('cart');

    return redirect()->route('items.invoice', $order->id)
                     ->with('success', 'Your order has been placed successfully!');
}
}

