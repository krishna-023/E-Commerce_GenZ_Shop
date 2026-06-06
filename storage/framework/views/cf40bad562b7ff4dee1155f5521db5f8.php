<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-map-marker-alt me-2"></i> Delivery Address</h5>
    <form action="<?php echo e(route('account.address.save')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Label (Home, Work, etc.)</label>
            <input type="text" class="form-control" name="label" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
        </div>
        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="city" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ZIP / Postal Code</label>
            <input type="text" class="form-control" name="zip">
        </div>
        <button type="submit" class="btn btn-primary rounded-pill">Save Address</button>
    </form>

    <?php if(!empty($addresses)): ?>
    <hr>
    <h6 class="fw-bold">Saved Addresses</h6>
    <ul class="list-group">
        <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item">
            <strong><?php echo e($addr['label']); ?>:</strong> <?php echo e($addr['address']); ?>, <?php echo e($addr['city']); ?> <?php echo e($addr['zip'] ?? ''); ?>

        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/account/delivery-address.blade.php ENDPATH**/ ?>