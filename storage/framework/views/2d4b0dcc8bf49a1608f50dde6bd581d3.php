<?php $__env->startSection('title', 'Buy Now Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h3 class="mb-4">🛒 Buy Now Checkout</h3>

    <?php $item = reset($cart); ?>
    <?php $item = (object) $item; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card p-3 mb-3">
                <h5>Item</h5>
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('storage/'.$item->image)); ?>" width="80" class="me-3" alt="<?php echo e($item->title); ?>">
                    <div>
                        <h6><?php echo e($item->title); ?></h6>
                        <p>Price: Rs. <?php echo e(number_format($item->final_price, 2)); ?></p>
                        <p>Quantity: <?php echo e($item->quantity); ?></p>
                        <p>Subtotal: Rs. <?php echo e(number_format($item->subtotal, 2)); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Delivery & Payment</h5>
                <form id="checkoutForm" action="<?php echo e(route('items.placeOrder', $itemId)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="quantity" value="<?php echo e($item->quantity); ?>">

                    
                    <?php $__currentLoopData = $deliveryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input class="form-check-input delivery-type" type="radio" name="delivery_option" value="<?php echo e($type); ?>" id="delivery_<?php echo e($type); ?>" <?php echo e($loop->first ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="delivery_<?php echo e($type); ?>">
                                <?php echo e($type); ?> <?php if($charge > 0): ?> (+Rs. <?php echo e(number_format($charge,2)); ?>) <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <hr>
                    
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="customer_name" class="form-control" value="<?php echo e(Auth::user()->name ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="customer_phone" class="form-control" value="<?php echo e(Auth::user()->phone ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
    <label>Delivery Address</label>

    <?php if(!empty($addresses)): ?>
        <select name="customer_address" id="savedAddress" class="form-select">
            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($address['address']); ?>" <?php echo e($address['is_default'] ?? false ? 'selected' : ''); ?>>
                    <?php echo e($address['label'] ?? 'Address'); ?> - <?php echo e($address['address']); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <small class="text-muted d-block mt-1">Or use current location / enter new address</small>
    <?php endif; ?>

    <input type="text"
           name="customer_address_new"
           id="currentAddress"
           class="form-control mt-2"
           placeholder="Current or New Address">

    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="useLocationBtn">
        📍 Use My Current Location
    </button>

    
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
</div>

                    <div class="mb-3">
                        <label>Preferred Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" value="<?php echo e(old('delivery_date')); ?>">
                    </div>

                    
                    <div class="mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>

                    
                    <div class="mb-3" id="gatewayDiv" style="display:none;">
                        <label>Select Payment Gateway</label>
                        <select name="gateway" class="form-select">
                            <option value="esewa">eSewa</option>
                            <option value="fonepay">FonePay</option>
                        </select>
                    </div>

                    <h5>Total: Rs. <span id="total_display"><?php echo e(number_format($item->subtotal + current($deliveryCharges), 2)); ?></span></h5>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('.delivery-type');
    const subtotal = parseFloat('<?php echo e($item->subtotal); ?>');
    const deliveryChargeEl = document.getElementById('total_display');

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            const charges = <?php echo json_encode($deliveryCharges, 15, 512) ?>;
            const charge = charges[this.value] || 0;
            deliveryChargeEl.textContent = (subtotal + charge).toFixed(2);
        });
    });

    // Show/Hide Gateway selection based on payment method
    const paymentSelect = document.getElementById('payment_method');
    const gatewayDiv = document.getElementById('gatewayDiv');
    paymentSelect.addEventListener('change', function() {
        if(this.value === 'Online Payment'){
            gatewayDiv.style.display = 'block';
        } else {
            gatewayDiv.style.display = 'none';
        }
    });
});
document.getElementById('useLocationBtn').addEventListener('click', function () {

    if (!navigator.geolocation) {
        alert("Geolocation is not supported by your browser.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // OPTIONAL: Reverse Geocoding (OpenStreetMap - FREE)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('currentAddress').value = data.display_name;
                    } else {
                        document.getElementById('currentAddress').value =
                            `Lat: ${lat}, Lng: ${lng}`;
                    }
                })
                .catch(() => {
                    document.getElementById('currentAddress').value =
                        `Lat: ${lat}, Lng: ${lng}`;
                });
        },
        function (error) {
            alert("Unable to fetch location. Please allow location access.");
        }
    );
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/checkout_buynow.blade.php ENDPATH**/ ?>