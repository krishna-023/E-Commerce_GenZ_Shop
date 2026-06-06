<?php $__env->startSection('title', 'Shop Home'); ?>

<?php $__env->startSection('css'); ?>
<style>
/* Hero Banner */
.hero-banner {
    background: url('<?php echo e(asset('admin/images/success-img.png')); ?>') ;
    height: 100px;
    border-radius: 12px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-shadow: 0 3px 15px rgba(0,0,0,0.7);
    font-size: 3rem;
    font-weight: bold;
}
/* Banner Slider */
.banner-slider {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 2rem;
}
.banner-slider img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.5s ease, box-shadow 0.3s ease;
}
.banner-slider a:hover img {
    transform: scale(1.05);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}

/* Slick Dots */
.banner-slider .slick-dots {
    bottom: 15px;
}
.banner-slider .slick-dots li button:before {
    font-size: 12px;
    color: #fff;
    opacity: 0.6;
}
.banner-slider .slick-dots li.slick-active button:before {
    color: #0d6efd;
    opacity: 1;
}

/* Slick Arrows */
.banner-slider .slick-prev,
.banner-slider .slick-next {
    z-index: 100;
    width: 45px;
    height: 45px;
    background: rgba(0,0,0,0.4);
    border-radius: 50%;
    display: flex !important;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
}
.banner-slider .slick-prev:hover,
.banner-slider .slick-next:hover {
    background: rgba(0,0,0,0.7);
}
.banner-slider .slick-prev:before,
.banner-slider .slick-next:before {
    font-size: 22px;
    color: #fff;
}


/* Section Header */
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.section-header h4 { font-weight: 600; }

/* Product Card */
.product-card {
    border: 1px solid #eaeaea;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    transition: all 0.3s ease-in-out;
    position: relative;
}
.product-card:hover { transform: translateY(-6px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.product-card img { width: 100%; height: 220px; object-fit: cover; }
.product-card .card-body { padding: 0.9rem; text-align: center; }
.product-price { font-weight: bold; color: #0d6efd; font-size: 1rem; }
.product-old-price { text-decoration: line-through; color: #6c757d; margin-left: 0.4rem; font-size: 0.9rem; }
.badge-discount {
    position: absolute; top: 12px; left: 12px;
    background: #dc3545; color: #fff; padding: 5px 8px;
    font-size: 0.75rem; border-radius: 5px;
}

/* Quick Add */
.quick-add { position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); opacity: 0; transition: all 0.3s; }
.product-card:hover .quick-add { opacity: 1; }

/* Rating Stars */
.rating { color: #ffc107; font-size: 0.9rem; margin-bottom: 5px; }

/* Category Slider */
.category-slider img {
    width: 80px; height: 80px; object-fit: cover; border-radius: 50%; margin: 0 auto;
    border: 2px solid #ddd; transition: transform 0.3s;
}
.category-slider img:hover { transform: scale(1.1); }
.category-slider h6 { text-align: center; margin-top: 0.5rem; font-size: 0.9rem; }
.category-logo { text-decoration: none; color: #333; text-align: center; display: block; }
.category-circle {
    width: 80px; height: 80px; background: #0d6efd; color: #fff;
    font-weight: bold; font-size: 1.2rem; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem auto;
    transition: background 0.3s, transform 0.3s;
}
.category-logo:hover .category-circle { background: #084298; transform: scale(1.1); }

/* Slick Arrows */
.slick-prev:before, .slick-next:before { color: #0d6efd; font-size: 30px; }

/* Countdown */
#countdown { font-size: 1rem; background: #fff3cd; padding: 6px 12px; border-radius: 5px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">

    
    <div class="hero-banner">Welcome to Our Shop</div>

    
    <div class="section-header"><h4>🛍️ Shop by Category</h4></div>
     <div class="category-slider mb-5">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <a href="<?php echo e(route('shopbycategory', $category->id)); ?>" class="category-logo">
                    <div class="category-circle"><?php echo e(strtoupper(substr($category->Category_Name, 0, 2))); ?></div>
                    <h6><?php echo e($category->Category_Name); ?></h6>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </div>

<?php if($dealBanners->count()): ?>
    <div class="banner-slider mb-4">
        <?php $__currentLoopData = $dealBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <a href="<?php echo e($banner->link ?? '#'); ?>">
                    <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="img-fluid rounded w-100" alt="<?php echo e($banner->title ?? 'Deals Banner'); ?>">
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
    
    <div class="section-header">
        <h4>🔥 Deals of the Day</h4>
        <div id="countdown" class="text-danger fw-bold"></div>
    </div>
    <div class="deals-slider mb-5">
        <?php $__currentLoopData = $dealsOfTheDay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-card">
                <?php if($item->discount_percentage): ?>
                    <div class="badge-discount"><?php echo e($item->discount_percentage); ?>% OFF</div>
                <?php endif; ?>
                <a href="<?php echo e(route('item.userview', $item->id)); ?>">
                    <img src="<?php echo e(asset('storage/' . ($item->image ?? 'no-image.png'))); ?>" alt="<?php echo e($item->title); ?>">
                </a>
                <div class="card-body">
                    <h6><?php echo e($item->title); ?></h6>
                    <div class="rating"><?php echo str_repeat('★', rand(3,5)); ?><?php echo str_repeat('☆', 5 - rand(3,5)); ?></div>
                    <h4 class="text-danger">
                        Rs. <?php echo e(number_format($item->price - ($item->price * $item->discount_percentage / 100), 2)); ?>

                        <?php if($item->discount_percentage > 0): ?>
                            <small class="text-muted"><del>Rs. <?php echo e(number_format($item->price, 2)); ?></del></small>
                        <?php endif; ?>
                    </h4>
<p>Expected Delivery: <span id="expected_delivery"></span></p>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST"><?php echo csrf_field(); ?><input type="hidden" name="quantity" value="1"><button class="btn btn-sm btn-primary">Add to Cart</button></form>
<form action="<?php echo e(route('checkout.buyNow', $item->id)); ?>" method="GET">
    <input type="hidden" name="quantity" value="1">
    <button class="btn btn-sm btn-success">Buy Now</button>
</form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php if($recommendedBanners->count()): ?>
    <div class="banner-slider mb-4">
        <?php $__currentLoopData = $recommendedBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <a href="<?php echo e($banner->link ?? '#'); ?>">
                    <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="img-fluid rounded w-100" alt="<?php echo e($banner->title ?? 'Recommended Banner'); ?>">
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
    
    <div class="section-header"><h4>🤝 Recommended for You</h4></div>
    <div class="recommended-slider mb-5">
        <?php $__currentLoopData = $recommendedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-card">
                <?php if($item->discount_percentage): ?>
                    <div class="badge-discount"><?php echo e($item->discount_percentage); ?>% OFF</div>
                <?php endif; ?>
                <a href="<?php echo e(route('item.view', $item->id)); ?>">
                    <img src="<?php echo e(asset('storage/' . ($item->image ?? 'no-image.png'))); ?>" alt="<?php echo e($item->title); ?>">
                </a>
                <div class="card-body">
                    <h6><?php echo e($item->title); ?></h6>
                    <div class="rating"><?php echo str_repeat('★', rand(3,5)); ?><?php echo str_repeat('☆', 5 - rand(3,5)); ?></div>
                    <h4 class="text-danger">
                        Rs. <?php echo e(number_format($item->price - ($item->price * $item->discount_percentage / 100), 2)); ?>

                        <?php if($item->discount_percentage > 0): ?>
                            <small class="text-muted"><del>Rs. <?php echo e(number_format($item->price, 2)); ?></del></small>
                        <?php endif; ?>
                    </h4>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST"><?php echo csrf_field(); ?><input type="hidden" name="quantity" value="1"><button class="btn btn-sm btn-primary">Add to Cart</button></form>
                        <form action="<?php echo e(route('checkout.buyNow', $item->id)); ?>" method="GET"><input type="hidden" name="quantity" value="1"><button class="btn btn-sm btn-success">Buy Now</button></form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php if($latestBanners->count()): ?>
    <div class="banner-slider mb-4">
        <?php $__currentLoopData = $latestBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <a href="<?php echo e($banner->link ?? '#'); ?>">
                    <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="img-fluid rounded w-100" alt="<?php echo e($banner->title ?? 'Latest Banner'); ?>">
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
    
    <div class="section-header"><h4>🆕 Latest Products</h4></div>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $latestItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3 col-sm-6">
                <div class="product-card">
                    <?php if($item->discount_percentage): ?>
                        <div class="badge-discount"><?php echo e($item->discount_percentage); ?>% OFF</div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('item.view', $item->id)); ?>">
                        <img src="<?php echo e(asset('storage/' . ($item->image ?? 'no-image.png'))); ?>" alt="<?php echo e($item->title); ?>">
                    </a>
                    <div class="card-body">
                        <h6><?php echo e($item->title); ?></h6>
                        <div class="rating"><?php echo str_repeat('★', rand(3,5)); ?><?php echo str_repeat('☆', 5 - rand(3,5)); ?></div>
                        <h4 class="text-danger">
                            Rs. <?php echo e(number_format($item->price - ($item->price * $item->discount_percentage / 100), 2)); ?>

                            <?php if($item->discount_percentage > 0): ?>
                                <small class="text-muted"><del>Rs. <?php echo e(number_format($item->price, 2)); ?></del></small>
                            <?php endif; ?>
                        </h4>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST"><?php echo csrf_field(); ?><input type="hidden" name="quantity" value="1"><button class="btn btn-sm btn-primary">Add to Cart</button></form>
                            <form action="<?php echo e(route('checkout.buyNow', $item->id)); ?>" method="GET"><input type="hidden" name="quantity" value="1"><button class="btn btn-sm btn-success">Buy Now</button></form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center">No products available.</p>
        <?php endif; ?>
    </div>

    
    <div class="mt-4 d-flex justify-content-center">
        <?php echo e($latestItems->links('pagination::bootstrap-5')); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
$(document).ready(function(){
    // Sliders
    $('.category-slider').slick({
        slidesToShow: 6, arrows: true,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 5 }},
            { breakpoint: 992, settings: { slidesToShow: 4 }},
            { breakpoint: 768, settings: { slidesToShow: 3 }},
            { breakpoint: 576, settings: { slidesToShow: 2 }}
        ]
    });
    $('.deals-slider, .recommended-slider').slick({
        slidesToShow: 4, arrows: true,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 }},
            { breakpoint: 992, settings: { slidesToShow: 2 }},
            { breakpoint: 576, settings: { slidesToShow: 1 }}
        ]
    });

    // Countdown
    let endTime = new Date("<?php echo e($flashSaleEnd); ?>").getTime();
    let timer = setInterval(() => {
        let distance = endTime - new Date().getTime();
        if(distance < 0){ $('#countdown').text("Sale Ended"); clearInterval(timer); return; }
        let h = Math.floor((distance % (1000*60*60*24))/(1000*60*60));
        let m = Math.floor((distance % (1000*60*60))/(1000*60));
        let s = Math.floor((distance % (1000*60))/1000);
        $('#countdown').text(`Ends in: ${h}h ${m}m ${s}s`);
    }, 1000);

    // Quick Add
    $('.quick-add').click(()=>alert('Item added to cart!'));
});
</script>
<script>
function updateDeliveryDate() {
    const type = document.getElementById('delivery_type').value;
    const orderDate = new Date(); // assuming order date is today
    let deliveryDate = new Date(orderDate);

    if(type === 'Express') deliveryDate.setDate(deliveryDate.getDate() + 2);
    if(type === 'Normal') deliveryDate.setDate(deliveryDate.getDate() + 4);

    document.getElementById('expected_delivery').innerText = deliveryDate.toDateString();
}

// Initialize
updateDeliveryDate();
</script>
<script>
$(document).ready(function(){
    $('.banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/home.blade.php ENDPATH**/ ?>