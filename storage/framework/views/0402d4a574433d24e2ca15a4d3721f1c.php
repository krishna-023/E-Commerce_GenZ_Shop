<?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Banner Details</h2>

    <p><strong>Title:</strong> <?php echo e($banner->title); ?></p>
    <p><strong>Link:</strong> <a href="<?php echo e($banner->link); ?>" target="_blank"><?php echo e($banner->link); ?></a></p>
    <p><strong>Created By:</strong> <?php echo e($banner->creator?->name ?? 'N/A'); ?></p>
    <p><strong>Updated By:</strong> <?php echo e($banner->updater?->name ?? 'N/A'); ?></p>
    <p><strong>Status:</strong> <?php echo e($banner->is_active ? 'Active' : 'Inactive'); ?></p>

    <?php if($banner->image): ?>
        <img src="<?php echo e(asset('storage/'.$banner->image)); ?>" alt="Banner" class="img-fluid my-3" width="400">
    <?php endif; ?>

    <a href="<?php echo e(route('banners.index')); ?>" class="btn btn-secondary">Back</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/banners/show.blade.php ENDPATH**/ ?>