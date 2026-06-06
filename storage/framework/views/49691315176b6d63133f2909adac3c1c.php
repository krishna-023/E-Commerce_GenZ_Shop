<?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('Categories'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .table-hierarchy tbody tr td:first-child {
        padding-left: 20px;
    }
    .table-hierarchy .child-row td:first-child {
        padding-left: 40px;
    }
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Category <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Manage Categories <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Categories</h4>
                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
                    <i class="ri-add-line align-middle me-1"></i> Add Category
                </a>
            </div>
            <div class="card-body">
                <?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-hierarchy">
                        <thead>
                            <tr>
                                <th width="40%">Category Name</th>
                                <th width="15%">Reference ID</th>
                                <th width="15%">Parent</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($categories->count()): ?>
                                <?php
                                    function renderCategory($category, $level = 0) {
                                        $padding = 20 + ($level * 20);
                                        echo '<tr class="'.($level > 0 ? 'child-row' : '').'">';
                                        echo '<td style="padding-left: '.$padding.'px;">';
                                        if($level > 0) echo '<i class="ri-arrow-right-s-line text-muted me-1"></i>';
                                        echo e($category->Category_Name);
                                        echo '</td>';
                                        echo '<td><span class="text-muted">'.($category->reference_id ?? 'N/A').'</span></td>';
                                        echo '<td><span class="text-muted">'.($category->parent?->Category_Name ?? '-').'</span></td>';
                                        echo '<td class="action-buttons">
                                            <a href="'.route('categories.show', $category->id).'" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="'.route('categories.edit', $category->id).'" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <form action="'.route('categories.destroy', $category->id).'" method="POST" class="d-inline">
                                                '.csrf_field().method_field('DELETE').'
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </td>';
                                        echo '</tr>';

                                        if($category->children->count()) {
                                            foreach($category->children as $child) {
                                                renderCategory($child, $level + 1);
                                            }
                                        }
                                    }
                                ?>

                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php renderCategory($category) ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ri-folder-open-line text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-2">No categories found. Create your first category!</p>
                                            <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary mt-2">
                                                <i class="ri-add-line align-middle me-1"></i> Add Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/category/index.blade.php ENDPATH**/ ?>