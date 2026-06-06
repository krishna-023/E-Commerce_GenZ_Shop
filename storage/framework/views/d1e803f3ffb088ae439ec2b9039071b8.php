<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Users List</h4>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(Auth::user()->role === 'super-admin'): ?>
            <div class="card shadow-lg border-0 rounded-4 mb-3">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <h5 class="mb-0 fw-bold"><i class="fa fa-users me-2"></i> Add New User</h5>
                    <a href="<?php echo e(route('user.create')); ?>" class="btn btn-success btn-lg rounded-pill shadow-sm">
                        <i class="fa fa-user-plus me-2"></i> Add User
                    </a>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="mb-3 d-flex align-items-center gap-2">
            <select id="bulk-action-select" class="form-select w-auto">
                <option value="">Select Action</option>
                <option value="send_message">Send Message</option>
                <option value="send_email">Send Email</option>
            </select>
            <button type="button" class="btn btn-primary" id="bulk-action-btn">Apply</button>
        </div>

        <form id="users-form">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><input type="checkbox" name="user_ids[]" value="<?php echo e($user->id); ?>" class="user-checkbox"></td>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><span class="badge bg-primary"><?php echo e(ucfirst($user->role)); ?></span></td>
                            <td>
                                
                            </td>
                            <td>
                                <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?php echo e(route('user.destroy', $user->id)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No users found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>

        
        <div class="mt-3">
            <?php echo e($users->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>


<div class="modal fade" id="bulkActionModal" tabindex="-1" aria-labelledby="bulkActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="bulkActionForm" method="POST" action="<?php echo e(route('users.bulkAction')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" id="modal-action">
            <input type="hidden" name="user_ids" id="modal-user-ids">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkActionModalLabel">Send Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message" class="form-label">Message / Email Content</label>
                        <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Select all checkboxes
    document.getElementById('select-all').addEventListener('change', function(e) {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = e.target.checked);
    });

    // Handle bulk action button click
    document.getElementById('bulk-action-btn').addEventListener('click', function() {
        const action = document.getElementById('bulk-action-select').value;
        if(!action) {
            alert('Please select an action first!');
            return;
        }

        const selected = Array.from(document.querySelectorAll('.user-checkbox:checked'))
            .map(cb => cb.value);

        if(selected.length === 0) {
            alert('Please select at least one user!');
            return;
        }

        document.getElementById('modal-action').value = action;
        document.getElementById('modal-user-ids').value = selected.join(',');

        var modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
        modal.show();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/users/index.blade.php ENDPATH**/ ?>