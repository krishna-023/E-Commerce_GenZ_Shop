<?php $__env->startSection('title', $category->Category_Name . ' | Shop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h3 class="mb-4">🛍️ <?php echo e($category->Category_Name); ?></h3>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3 col-sm-6">
                <div class="product-card">
                    <?php if($item->discount_percentage): ?>
                        <div class="badge-discount"><?php echo e($item->discount_percentage); ?>% OFF</div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('item.view', $item->id)); ?>">
                        <img src="<?php echo e(asset('storage/' . ($item->image ?? 'no-image.png'))); ?>" alt="<?php echo e($item->title); ?>">
                    </a>
                    <div class="card-body">
                        <h6><?php echo e($item->title); ?></h6>
                        <div class="rating">★★★★★</div>
                        <p>
                            <span class="product-price"><?php echo e($item->price ?? 'N/A'); ?></span>
                            <?php if($item->actual_price): ?>
                                <span class="product-old-price"><?php echo e($item->actual_price); ?></span>
                            <?php endif; ?>
                        </p>
                        <button class="btn btn-sm btn-success quick-add">Quick Add</button>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">No products found in this category.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/partials/shopbyCategory.blade.php ENDPATH**/ ?>