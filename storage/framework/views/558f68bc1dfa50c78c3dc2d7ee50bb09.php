<?php $__env->startSection('title', 'Cart Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h3 class="mb-4">🛒 Checkout</h3>

    <?php if(!empty($cart) && count($cart) > 0): ?>
    <div class="row">
        
        <div class="col-md-8">
            <table class="table table-bordered align-middle" id="cartTable">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th width="120">Price</th>
                        <th width="100">Qty</th>
                        <th width="120">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $subtotal = 0; ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $finalPrice = $item['final_price'] ?? ($item['price'] - ($item['price'] * ($item['discount_percentage'] ?? 0) / 100));
                            $quantity = $item['quantity'];
                            $itemSubtotal = $finalPrice * $quantity;
                            $subtotal += $itemSubtotal;
                        ?>
                        <tr data-id="<?php echo e($id); ?>">
                            <td>
                                <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" width="50" class="me-2 rounded" alt="<?php echo e($item['title']); ?>">
                                <?php echo e($item['title']); ?>

                                <?php if(($item['discount_percentage'] ?? 0) > 0): ?>
                                    <span class="badge bg-danger ms-2"><?php echo e($item['discount_percentage']); ?>% OFF</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                Rs. <?php echo e(number_format($finalPrice,2)); ?>

                                <input type="hidden" class="item-price" value="<?php echo e($finalPrice); ?>">
                            </td>
                            <td><?php echo e($quantity); ?></td>
                            <td class="item-subtotal">Rs. <?php echo e(number_format($itemSubtotal,2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="col-md-4">
            <form action="<?php echo e(route('cart.placeOrder')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card p-3">
                    <h5>Delivery Options</h5>
                    <?php $__currentLoopData = $deliveryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input class="form-check-input delivery-type" type="radio" name="delivery_option" value="<?php echo e($type); ?>" id="delivery_<?php echo e($type); ?>" <?php echo e($loop->first ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="delivery_<?php echo e($type); ?>">
                                <?php echo e($type); ?> <?php if($charge>0): ?> (+Rs. <?php echo e(number_format($charge,2)); ?>) <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <hr>
                    <h5>Order Summary</h5>
                    <p>Items Total: Rs. <span id="items_total"><?php echo e(number_format($subtotal,2)); ?></span></p>
                    <p>Delivery Charge: Rs. <span id="delivery_charge"><?php echo e(number_format(current($deliveryCharges),2)); ?></span></p>
                    <p class="fw-bold">Grand Total: Rs. <span id="grand_total"><?php echo e(number_format($subtotal + current($deliveryCharges),2)); ?></span></p>

                    
                    <div class="mt-3">
                        <label>Name</label>
                        <input type="text" name="customer_name" class="form-control" value="<?php echo e(Auth::user()->name ?? ''); ?>" required>
                    </div>
                    <div class="mt-3">
                        <label>Phone</label>
                        <input type="text" name="customer_phone" class="form-control" value="<?php echo e(Auth::user()->phone ?? ''); ?>" required>
                    </div>

                    
                    <?php if(!empty($addresses)): ?>
                        <div class="mt-3">
                            <label>Delivery Address</label>
                            <select name="customer_address" class="form-select">
                                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($address['address']); ?>" <?php echo e(($address['is_default'] ?? false) ? 'selected' : ''); ?>>
                                        <?php echo e($address['label'] ?? 'Address'); ?> - <?php echo e($address['address']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted">Or enter a new address below</small>
                        </div>
                    <?php endif; ?>

                    
                    <div class="mt-3">
                        <label>New Address</label>
                        <input type="text" name="customer_address_new" class="form-control" placeholder="Enter new address if not in saved addresses">
                        <div class="form-check mt-1">
                            <input type="checkbox" name="is_default" value="1" class="form-check-input" id="defaultAddress">
                            <label class="form-check-label" for="defaultAddress">Set as Default</label>
                        </div>
                    </div>

                    
                    <div class="mt-3">
                        <label>Preferred Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" value="<?php echo e(old('delivery_date')); ?>">
                    </div>

                    
                    <div class="mt-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>

                    
                    <div class="mt-4">
                        <h4>Total: Rs. <span id="total_display"><?php echo e(number_format($subtotal + current($deliveryCharges),2)); ?></span></h4>
                        <button type="submit" class="btn btn-success w-100">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php else: ?>
        <p>Your cart is empty. <a href="<?php echo e(route('home')); ?>">Shop now!</a></p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryRadios = document.querySelectorAll('.delivery-type');
    const itemsTotal = parseFloat('<?php echo e($subtotal); ?>');
    const deliveryChargeEl = document.getElementById('delivery_charge');
    const grandTotalEl = document.getElementById('grand_total');
    const totalDisplay = document.getElementById('total_display');

    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const charges = <?php echo json_encode($deliveryCharges, 15, 512) ?>;
            const charge = charges[this.value] || 0;
            deliveryChargeEl.textContent = charge.toFixed(2);
            grandTotalEl.textContent = (itemsTotal + charge).toFixed(2);
            totalDisplay.textContent = (itemsTotal + charge).toFixed(2);
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/checkout_cart.blade.php ENDPATH**/ ?>