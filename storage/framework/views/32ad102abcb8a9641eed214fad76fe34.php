<?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">📢 Active Banners</h2>
        <a href="<?php echo e(route('banners.create')); ?>" class="btn btn-primary">
            + Add Banner
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success shadow-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card shadow rounded-3">
        <div class="card-body table-responsive">
            <table class="table align-middle table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Category</th> 
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($banner->image): ?>
                                <img src="<?php echo e(asset('storage/'.$banner->image)); ?>"
                                     alt="<?php echo e($banner->title); ?>"
                                     class="img-thumbnail rounded"
                                     style="width: 120px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?php echo e($banner->title ?? 'Untitled'); ?></td>
                        <td><?php echo e($banner->user?->name ?? 'N/A'); ?></td>

                        
                        <td>
                            <?php if($banner->category): ?>
                                <span class="badge bg-primary"><?php echo e($banner->category); ?></span>
                            <?php else: ?>
                                <span class="text-muted">Unassigned</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($banner->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($banner->created_at->format('Y-m-d H:i')); ?></td>
                        <td><?php echo e($banner->updated_at->format('Y-m-d H:i')); ?></td>
                        <td><?php echo e($banner->creator?->name ?? 'N/A'); ?></td>
                        <td><?php echo e($banner->updater?->name ?? 'N/A'); ?></td>
                        <td>
                            <a href="<?php echo e(route('banners.show', $banner->id)); ?>"
                               class="btn btn-sm btn-info me-1">View</a>
                            <a href="<?php echo e(route('banners.edit', $banner->id)); ?>"
                               class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="<?php echo e(route('banners.destroy', $banner->id)); ?>"
                                  method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this banner?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-muted">No active banners found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="d-flex justify-content-center mt-3">
        <?php echo e($banners->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>