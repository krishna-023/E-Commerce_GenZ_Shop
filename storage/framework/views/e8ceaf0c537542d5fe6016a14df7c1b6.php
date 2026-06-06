<?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Edit Banner</h2>

    <form action="<?php echo e(route('banners.update', $banner->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="form-group">
    <label for="category">Banner Category</label>
    <select name="category" id="category" class="form-control" required>
        <option value="">-- Select Category --</option>
        <option value="deals" <?php echo e(old('category', $banner->category ?? '') == 'deals' ? 'selected' : ''); ?>>Deals of the Day</option>
        <option value="recommended" <?php echo e(old('category', $banner->category ?? '') == 'recommended' ? 'selected' : ''); ?>>Recommended for You</option>
        <option value="latest" <?php echo e(old('category', $banner->category ?? '') == 'latest' ? 'selected' : ''); ?>>Latest Products</option>
    </select>
</div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo e(old('title', $banner->title)); ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Link</label>
            <input type="url" name="link" value="<?php echo e(old('link', $banner->link)); ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Active</label>
            <select name="is_active" class="form-control">
                <option value="1" <?php echo e($banner->is_active ? 'selected' : ''); ?>>Yes</option>
                <option value="0" <?php echo e(!$banner->is_active ? 'selected' : ''); ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label><br>
            <?php if($banner->image): ?>
                <img src="<?php echo e(asset('storage/'.$banner->image)); ?>" alt="Banner" width="200" class="mb-2"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?php echo e(route('banners.index')); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/banners/edit.blade.php ENDPATH**/ ?>