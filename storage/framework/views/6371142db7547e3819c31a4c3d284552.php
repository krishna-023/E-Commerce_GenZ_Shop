<?php $__env->startSection('title', 'View Item'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .main-image {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .product-gallery img {
        cursor: pointer;
        border-radius: 4px;
        transition: transform 0.3s ease;
    }
    .product-gallery img:hover {
        transform: scale(1.05);
    }
    .tab-content p, .tab-content ul {
        margin-bottom: 0.8rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">

    <div class="row">

        
        <div class="col-md-6">
            <?php if($item->image): ?>
                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" class="img-fluid main-image" id="mainImage" alt="<?php echo e($item->title); ?>">
            <?php endif; ?>

            
            <?php if($item->sellers && $item->sellers->count() > 0): ?>
                <div class="row g-2 product-gallery mt-2">
                    <?php $__currentLoopData = $item->sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($seller->gallery && is_array($seller->gallery)): ?>
                            <?php $__currentLoopData = $seller->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-3 mb-2">
                                    <img src="<?php echo e(asset('storage/sellers/' . $img)); ?>" class="img-fluid" onclick="document.getElementById('mainImage').src=this.src" alt="Gallery Image">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-md-6">
            <h2><?php echo e($item->title); ?></h2>
            <p class="text-muted"><?php echo e($item->subtitle); ?></p>
            <p><strong>Price:</strong> <?php echo e($item->price ?? 'N/A'); ?> | <strong>Actual Price:</strong> <?php echo e($item->actual_price ?? 'N/A'); ?></p>
            <p><strong>Discount:</strong> <?php echo e($item->discount_percentage ?? '0'); ?>%</p>
            <p><strong>Stocks:</strong> <?php echo e($item->stocks ?? 'N/A'); ?></p>

            
            <ul class="nav nav-tabs mt-4" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sellers-tab" data-bs-toggle="tab" data-bs-target="#sellers" type="button" role="tab">Sellers</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">Specifications</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab">Gallery</button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0" id="productTabContent">

                
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <p><?php echo nl2br(e($item->description)); ?></p>
                    <p><strong>Item Features:</strong> <?php echo nl2br(e($item->item_features)); ?></p>
                </div>

                
                <div class="tab-pane fade" id="sellers" role="tabpanel">
                    <?php if($item->sellers && $item->sellers->count() > 0): ?>
                        <?php $__currentLoopData = $item->sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><strong>Name:</strong> <?php echo e($seller->seller_name); ?></p>
                            <p><strong>Email:</strong> <a href="mailto:<?php echo e($seller->seller_email); ?>"><?php echo e($seller->seller_email); ?></a></p>
                            <p><strong>Phone:</strong> <a href="tel:<?php echo e($seller->seller_phone); ?>"><?php echo e($seller->seller_phone); ?></a></p>
                            <p><strong>Address:</strong> <?php echo e($seller->seller_address); ?></p>
                            <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p>No sellers available.</p>
                    <?php endif; ?>
                </div>

                
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <?php if($item->specifications && $item->specifications->count() > 0): ?>
                        <?php $__currentLoopData = $item->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <ul>
                                <li><strong>Size:</strong> <?php echo e($spec->size ?? 'N/A'); ?></li>
                                <li><strong>Weight:</strong> <?php echo e($spec->weight ?? 'N/A'); ?></li>
                                <li><strong>Height:</strong> <?php echo e($spec->height ?? 'N/A'); ?></li>
                                <li><strong>Width:</strong> <?php echo e($spec->width ?? 'N/A'); ?></li>
                                <li><strong>Thickness:</strong> <?php echo e($spec->thickness ?? 'N/A'); ?></li>
                                <li><strong>Color:</strong> <?php echo e($spec->color ?? 'N/A'); ?></li>
                                <li><strong>Quantity:</strong> <?php echo e($spec->quantity ?? 'N/A'); ?></li>
                                <li><strong>Details:</strong> <?php echo nl2br(e($spec->item_details)); ?></li>
                            </ul>
                            <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p>No specifications available.</p>
                    <?php endif; ?>
                </div>

                
                <div class="tab-pane fade" id="gallery" role="tabpanel">
                    <?php if($item->sellers && $item->sellers->count() > 0): ?>
                        <div class="row g-2 product-gallery">
                            <?php $__currentLoopData = $item->sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($seller->gallery && is_array($seller->gallery)): ?>
                                    <?php $__currentLoopData = $seller->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-3 mb-2">
                                            <img src="<?php echo e(asset('storage/sellers/' . $img)); ?>" class="img-fluid" onclick="document.getElementById('mainImage').src=this.src" alt="Gallery Image">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p>No gallery images available.</p>
                    <?php endif; ?>
                </div>

            </div>

            <a href="<?php echo e(route('item.index')); ?>" class="btn btn-primary mt-3">Back to List</a>

        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Main image update
    const galleryImages = document.querySelectorAll('.product-gallery img');
    const mainImage = document.getElementById('mainImage');

    galleryImages.forEach(img => {
        img.addEventListener('click', () => {
            mainImage.src = img.src;
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/view.blade.php ENDPATH**/ ?>