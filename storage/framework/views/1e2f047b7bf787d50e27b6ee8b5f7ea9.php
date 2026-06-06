<?php
    $alertTypes = [
        'primary'   => 'ri-user-smile-line',
        'secondary' => 'ri-check-double-line',
        'success'   => 'ri-notification-off-line',
        'danger'    => 'ri-error-warning-line',
        'warning'   => 'ri-alert-line',
        'info'      => 'ri-airplay-line',
        'light'     => 'ri-mail-line',
        'dark'      => 'ri-refresh-line'
    ];
?>

<?php $__currentLoopData = $alertTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session()->has($type)): ?>
        <div class="alert alert-<?php echo e($type); ?> alert-border-left alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="<?php echo e($icon); ?> me-2 fs-4"></i>
            <div>
                <strong><?php echo e(ucfirst($type)); ?>:</strong> <?php echo e(session()->get($type)); ?>

            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/common/flash.blade.php ENDPATH**/ ?>