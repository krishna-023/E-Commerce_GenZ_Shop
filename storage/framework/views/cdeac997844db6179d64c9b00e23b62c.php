<?php $__env->startSection('title', 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $user = isset($editUser) ? $editUser : Auth::user(); // User being edited
    $currentUser = Auth::user(); // Logged-in user

    // Can the logged-in user edit role/permissions?
    $canEditRoles = $currentUser->role === 'super-admin' || ($currentUser->role === 'admin' && $user->role !== 'super-admin');

    // Ensure permissions are an array
    $userPermissions = is_array($user->permissions) ? $user->permissions : json_decode($user->permissions, true) ?? [];
?>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Pages <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Profile <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <!-- Profile Picture -->
    <div class="col-xl-3">
        <div class="card mb-4 text-center">
            <div class="card-body">
                <img id="profilePreview"
                     src="<?php echo e($user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.png')); ?>"
                     alt="Profile Picture"
                     class="img-thumbnail rounded-circle mb-3"
                     style="width: 150px; height: 150px; object-fit: cover;">
                <h5><?php echo e($user->name); ?></h5>
                <p class="text-muted"><?php echo e($user->email); ?></p>
                <span class="badge bg-secondary"><?php echo e(ucfirst($user->role)); ?></span>
            </div>
        </div>
    </div>

    <!-- Profile Settings -->
    <div class="col-xl-9">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Profile Settings</h5>
                <form action="<?php echo e($canEditRoles ? route('user.update', $user->id) : route('profile.settings.update')); ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php if($canEditRoles): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?php echo e(old('username', $user->name)); ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo e(old('email', $user->email)); ?>" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Leave blank to keep current">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" placeholder="Leave blank to keep current">
                    </div>

                    <!-- Profile Picture -->
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>

                    <!-- Role & Permissions (Super-admin / Admin Editing Allowed Users) -->
                    <?php if($canEditRoles): ?>
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <?php $__currentLoopData = ['user','admin','super-admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($currentUser->role === 'admin' && $roleOption === 'super-admin'): ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <option value="<?php echo e($roleOption); ?>" <?php if($user->role === $roleOption): echo 'selected'; endif; ?>><?php echo e(ucfirst($roleOption)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Permissions -->
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="d-flex flex-column gap-2">
                                <?php $__currentLoopData = config('role_permissions.permissions'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card card-body p-2 mb-2">
                                        <strong><?php echo e($category); ?></strong>
                                        <div class="d-flex flex-wrap gap-3 mt-1">
                                            <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $canAssignPerm = $currentUser->role === 'super-admin'
                                                                     || ($currentUser->role === 'admin' && in_array($perm, config('role_permissions.roles.admin')));
                                                ?>

                                                <?php if($canAssignPerm): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="<?php echo e($perm); ?>"
                                                               id="perm_<?php echo e($perm); ?>"
                                                               <?php if(in_array($perm, $userPermissions)): echo 'checked'; endif; ?>>
                                                        <label class="form-check-label" for="perm_<?php echo e($perm); ?>">
                                                            <?php echo e(ucfirst(str_replace(['.', '_'], ' ', $perm))); ?>

                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User (Admin / Super-admin) -->
    <?php if($currentUser->role === 'admin' || $currentUser->role === 'super-admin'): ?>
        <div class="col-xl-9">
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Manage Users</h5>
                    <a href="<?php echo e(route('user.create')); ?>" class="btn btn-success">+ Add User</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('admin/js/app.js')); ?>"></script>
<script>
    document.getElementById('profile_picture')?.addEventListener('change', function (event) {
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

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/profile/settings.blade.php ENDPATH**/ ?>