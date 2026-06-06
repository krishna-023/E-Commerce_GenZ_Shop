<?php echo $__env->make('web.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="d-flex flex-column min-vh-100">

    
    <main class="flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('web.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    

    
    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldContent('script'); ?>
</body>
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/layouts/master.blade.php ENDPATH**/ ?>