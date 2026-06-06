<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.profile'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Pages <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Profile <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>


<?php if(session('success')): ?>
    <div class="alert alert-success shadow-sm rounded"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert alert-danger shadow-sm rounded">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    
    <div class="col-xl-3">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-body text-center p-4">
                <div class="position-relative d-inline-block">
                    <img
                        id="profilePreview"
                        src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png')); ?>"
                        alt="Profile Picture"
                        class="img-thumbnail rounded-circle shadow"
                        style="width: 160px; height: 160px; object-fit: cover; border: 5px solid #f8f9fa;">
                    <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-primary text-white rounded-circle shadow">
                        <i class="fa fa-camera"></i>
                    </span>
                </div>
                <h4 class="mt-3 mb-1 fw-bold"><?php echo e(Auth::user()->name); ?></h4>
                <p class="text-muted small mb-2"><i class="fa fa-envelope me-1"></i> <?php echo e(Auth::user()->email); ?></p>
                <span class="badge bg-success px-3 py-2 rounded-pill">Active User</span>
            </div>
        </div>

        
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 fw-bold"><i class="fa fa-camera me-2"></i> Update Profile Picture</h5>
                <form action="<?php echo e(route('profile.picture.update', Auth::user()->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="profile_picture" id="profile_picture_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fa fa-save me-2"></i> Update Picture
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-xl-9">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <h5 class="mb-0"><i class="fa fa-user-cog me-2"></i> Profile Settings</h5>
            </div>
            <div class="card-body p-4">
<form action="<?php echo e(route('profile.settings.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username"
                                   value="<?php echo e(Auth::user()->name); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                   value="<?php echo e(Auth::user()->email); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Change Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                   placeholder="Leave blank if unchanged">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                   name="password_confirmation" placeholder="Leave blank if unchanged">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-lg btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fa fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <?php if(Auth::user()->role === 'super-admin'): ?>
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <h5 class="mb-0 fw-bold"><i class="fa fa-users me-2"></i> Add New User</h5>
                    <a href="<?php echo e(route('user.create')); ?>" class="btn btn-success btn-lg rounded-pill shadow-sm">
                        <i class="fa fa-user-plus me-2"></i> Add User
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('admin/js/app.js')); ?>"></script>
<script>
    // Preview for profile picture upload
    document.getElementById('profile_picture_file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/profile/profile.blade.php ENDPATH**/ ?>