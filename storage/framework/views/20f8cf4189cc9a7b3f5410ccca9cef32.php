<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?php echo e(route('home')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="logo" height="22">
            </span>
        </a>
        <a href="<?php echo e(route('home')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt="logo" height="22">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">

                
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>

                <?php
                    $menu = config('role_permissions.menu');
                ?>

                
                <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Auth::user()->hasPermission($item['permission'])): ?>
                        <?php if(isset($item['children']) && count($item['children']) > 0): ?>
                            <!-- Parent menu with children -->
                            <li class="nav-item">
                                <a class="nav-link menu-link collapsed"
                                   href="#menu-<?php echo e(Str::slug($item['title'])); ?>"
                                   data-bs-toggle="collapse"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="menu-<?php echo e(Str::slug($item['title'])); ?>">
                                    <i class="<?php echo e($item['icon']); ?>"></i>
                                    <span><?php echo e($item['title']); ?></span>
                                </a>
                                <div class="collapse menu-dropdown" id="menu-<?php echo e(Str::slug($item['title'])); ?>">
                                    <ul class="nav nav-sm flex-column">
                                        <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(Auth::user()->hasPermission($child['permission'])): ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo e(route($child['route'])); ?>" class="nav-link">
                                                        <i class="<?php echo e($child['icon']); ?> me-1"></i>
                                                        <?php echo e($child['title']); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </li>
                        <?php else: ?>
                            <!-- Single menu item -->
                            <li class="nav-item">
                                <a href="<?php echo e(route($item['route'])); ?>" class="nav-link">
                                    <i class="<?php echo e($item['icon']); ?>"></i>
                                    <span><?php echo e($item['title']); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if(Auth::user()->role === 'super-admin'): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('user.index')); ?>" class="nav-link">
                            <i class="ri-team-line"></i>
                            <span>Users</span>
                        </a>
                    </li>
                <?php endif; ?>


<li class="menu-title"><span>Shop Management</span></li>

<li class="nav-item">
    <a href="<?php echo e(route('cart.index')); ?>" class="nav-link">
        <i class="ri-shopping-cart-line"></i>
        <span>Carts</span>
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link">
        <i class="ri-file-list-line"></i>
        <span>Orders</span>
    </a>
</li>



            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>