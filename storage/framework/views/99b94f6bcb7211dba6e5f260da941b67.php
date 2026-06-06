<?php $__env->startSection('title', $item->title ?? 'Product Details'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .breadcrumb { background: none; padding: 0; margin-bottom: 1rem; }
    .product-labels span {
        display: inline-block; padding: 4px 8px; border-radius: 4px;
        font-size: 0.8rem; margin-right: 5px; color: #fff;
    }
    .label-new { background: #28a745; }
    .label-bestseller { background: #ffc107; color: #000; }
    .main-image { width: 100%; border-radius: 8px; margin-bottom: 10px; }
    .product-gallery img { cursor: pointer; border-radius: 4px; transition: transform 0.3s; }
    .product-gallery img:hover { transform: scale(1.1); }
    .price { font-size: 1.8rem; font-weight: bold; color: #333; }
    .actual-price { text-decoration: line-through; color: #888; margin-left: 10px; font-size: 1.2rem; }
    .discount { color: red; font-weight: bold; margin-left: 10px; font-size: 1.2rem; }
    .rating i { color: #f0ad4e; }
    .quantity-input { width: 80px; display: inline-block; }
    .tab-content p, .tab-content ul { margin-bottom: 0.8rem; }
    .add-cart-buttons .btn { min-width: 130px; margin-right: 10px; margin-top: 10px; }
    @media (max-width: 768px) {
        .product-gallery .col-3 { flex: 0 0 25%; max-width: 25%; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">

    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('item.index')); ?>">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($item->title); ?></li>
        </ol>
    </nav>

    <div class="row g-4">

        
        <div class="col-md-6">
            <?php if($item->image): ?>
                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" class="img-fluid main-image" id="mainImage" alt="<?php echo e($item->title); ?>">
            <?php endif; ?>

            
            <?php if($item->sellers && $item->sellers->count() > 0): ?>
                <div class="row g-2 product-gallery mt-2">
                    <?php $__currentLoopData = $item->sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($seller->gallery && is_array($seller->gallery)): ?>
                            <?php $__currentLoopData = $seller->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-3">
                                    <img src="<?php echo e(asset('storage/sellers/' . $img)); ?>" class="img-fluid" onclick="document.getElementById('mainImage').src=this.src" alt="Gallery Image">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-md-6">
            <div class="product-labels mb-2">
                <span class="label-new">New</span>
                <span class="label-bestseller">Bestseller</span>
            </div>

            <h1><?php echo e($item->title); ?></h1>
            <p class="text-muted"><?php echo e($item->subtitle); ?></p>

            
            <div class="rating mb-2">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
            </div>

            
            <div class="mb-3">
                <span class="price">$<?php echo e($item->price ?? '0.00'); ?></span>
                <?php if($item->actual_price): ?>
                    <span class="actual-price">$<?php echo e($item->actual_price); ?></span>
                <?php endif; ?>
                <?php if($item->discount_percentage): ?>
                    <span class="discount"><?php echo e($item->discount_percentage); ?>% OFF</span>
                <?php endif; ?>
            </div>

            <p><strong>Stock:</strong> <?php echo e($item->stocks ?? 'N/A'); ?></p>

            
            <div class="add-cart-buttons mb-4">
                <label for="quantity" class="form-label me-2">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control quantity-input" value="1" min="1">
                <div>
                    <button class="btn btn-primary"><i class="fas fa-shopping-cart me-1"></i> Add to Cart</button>

<form action="<?php echo e(route('checkout.buyNow', $item->id)); ?>" method="GET" class="buy-now-form">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="btn btn-sm btn-success">Buy Now</button>
</form>
                </div>
            </div>

            
            <ul class="nav nav-tabs mt-4" id="productTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description">Description</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specifications">Specifications</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sellers">Sellers</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#gallery">Gallery</button>
                </li>
            </ul>

            <div class="tab-content p-3 border border-top-0" id="productTabContent">

                
                <div class="tab-pane fade show active" id="description">
                    <p><?php echo nl2br(e($item->description)); ?></p>
                    <p><strong>Features:</strong> <?php echo nl2br(e($item->item_features)); ?></p>
                </div>

                
                <div class="tab-pane fade" id="specifications">
                    <?php if($item->specifications && $item->specifications->count() > 0): ?>
                        <ul>
                            <?php $__currentLoopData = $item->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><strong>Size:</strong> <?php echo e($spec->size ?? 'N/A'); ?></li>
                                <li><strong>Weight:</strong> <?php echo e($spec->weight ?? 'N/A'); ?></li>
                                <li><strong>Height:</strong> <?php echo e($spec->height ?? 'N/A'); ?></li>
                                <li><strong>Width:</strong> <?php echo e($spec->width ?? 'N/A'); ?></li>
                                <li><strong>Thickness:</strong> <?php echo e($spec->thickness ?? 'N/A'); ?></li>
                                <li><strong>Color:</strong> <?php echo e($spec->color ?? 'N/A'); ?></li>
                                <li><strong>Quantity:</strong> <?php echo e($spec->quantity ?? 'N/A'); ?></li>
                                <li><strong>Details:</strong> <?php echo nl2br(e($spec->item_details)); ?></li>
                                <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p>No specifications available.</p>
                    <?php endif; ?>
                </div>

                
                <div class="tab-pane fade" id="sellers">
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

                
                <div class="tab-pane fade" id="gallery">
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

    // Sync quantity into Buy Now form so selected quantity is sent
    const buyNowForm = document.querySelector('.buy-now-form');
    if (buyNowForm) {
        buyNowForm.addEventListener('submit', function (e) {
            const qtyInput = document.querySelector('#quantity');
            const hiddenQty = this.querySelector('input[name="quantity"]');
            if (qtyInput && hiddenQty) {
                hiddenQty.value = Math.max(1, parseInt(qtyInput.value) || 1);
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/items/userview.blade.php ENDPATH**/ ?>