<?php $__env->startSection('title', 'Your Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h3 class="mb-4">Your Shopping Cart</h3>

    <?php if($cart && count($cart) > 0): ?>
        
        <form method="GET" class="row mb-3 g-2">
            <div class="col-md-3">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="price_asc" <?php echo e(request('sort')=='price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo e(request('sort')=='price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="from_date" value="<?php echo e(request('from_date')); ?>" class="form-control" placeholder="From Date">
            </div>
            <div class="col-md-3">
                <input type="date" name="to_date" value="<?php echo e(request('to_date')); ?>" class="form-control" placeholder="To Date">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
            </div>
        </form>

        
        <form action="<?php echo e(route('cart.checkoutSelected')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Select</th>
                        <th>Item</th>
                        <th width="120">Price</th>
                        <th width="100">Quantity</th>
                        <th width="120">Subtotal</th>
                        <th width="80">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $discount = $item['discount_percentage'] ?? 0;
                            $finalPrice = $item['price'] - ($item['price'] * $discount / 100);
                            $quantity = $item['quantity'];
                            $subtotal = $finalPrice * $quantity;
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="<?php echo e($id); ?>" checked>
                                <input type="hidden" name="quantities[<?php echo e($id); ?>]" value="<?php echo e($quantity); ?>">
                            </td>
                            <td>
                                <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" width="50" class="me-2 rounded" alt="<?php echo e($item['title']); ?>">
                                <?php echo e($item['title']); ?>

                                <?php if($discount > 0): ?>
                                    <span class="badge bg-danger ms-2"><?php echo e($discount); ?>% OFF</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <h5 class="text-danger mb-0">
                                    Rs. <?php echo e(number_format($finalPrice, 2)); ?>

                                    <?php if($discount > 0): ?>
                                        <small class="text-muted"><del>Rs. <?php echo e(number_format($item['price'], 2)); ?></del></small>
                                    <?php endif; ?>
                                </h5>
                            </td>
                            <td>
                                <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST" class="d-flex align-items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="number" name="quantity" value="<?php echo e($quantity); ?>" min="1" style="width:60px">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>Rs. <?php echo e(number_format($subtotal, 2)); ?></td>
                            <td>
                                <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">Rs. <?php echo e(number_format($total, 2)); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between mt-3">
                <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">Continue Shopping</a>
                <button type="submit" class="btn btn-success">Checkout Selected Items</button>
            </div>
        </form>

    <?php else: ?>
        <p>Your cart is empty. <a href="<?php echo e(route('home')); ?>">Shop now!</a></p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/items/cartsIndex.blade.php ENDPATH**/ ?>