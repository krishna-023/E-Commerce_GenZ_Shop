<?php $__env->startSection('title', 'Account Settings'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Pages <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Account Settings <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-3">
        
        <div class="card shadow-lg border-0 rounded-4 mb-4 text-center p-3">
            <img src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png')); ?>"
                 alt="Profile" class="img-thumbnail rounded-circle mb-3" style="width:120px;height:120px;">
            <h5 class="fw-bold"><?php echo e(Auth::user()->name); ?></h5>
            <p class="text-muted small"><?php echo e(Auth::user()->email); ?></p>
        </div>

        
        <div class="list-group shadow-lg rounded-4">
            <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">Profile Settings</a>
            <a href="#delivery" class="list-group-item list-group-item-action" data-bs-toggle="tab">Delivery Address</a>
            <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="tab">eSewa / Payments</a>
            <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="tab">Notifications</a>
            <a href="#theme" class="list-group-item list-group-item-action" data-bs-toggle="tab">Theme</a>
        </div>
    </div>

    <div class="col-xl-9">
        <div class="tab-content">

            
            <div class="tab-pane fade show active" id="profile">
                <?php echo $__env->make('admin.account.profile-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="tab-pane fade" id="delivery">
                <?php echo $__env->make('admin.account.delivery-address', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="tab-pane fade" id="payment">
                <?php echo $__env->make('admin.account.payment-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="tab-pane fade" id="notifications">
                <?php echo $__env->make('admin.account.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="tab-pane fade" id="theme">
                <?php echo $__env->make('admin.account.theme-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master-without-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/account/settings.blade.php ENDPATH**/ ?>