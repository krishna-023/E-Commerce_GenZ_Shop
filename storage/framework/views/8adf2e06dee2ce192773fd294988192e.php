<?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('title'); ?> Dashboard <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">

    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow rounded-lg p-3">
                <h5>Total Users</h5>
                <h2 id="totalUsers"><?php echo e($usersCount); ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow rounded-lg p-3">
                <h5>Total Categories</h5>
                <h2 id="totalCategories"><?php echo e($categoriesCount); ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow rounded-lg p-3">
                <h5>Total Items</h5>
                <h2 id="totalItems"><?php echo e($itemsCount); ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow rounded-lg p-3">
                <h5>Total Visitors</h5>
                <h2 id="totalContacts"><?php echo e($visitorsCount); ?></h2>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Users Registered Per Month</h5>
                <div id="usersChart"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Items Added vs Modified</h5>
                <div id="itemsChart"></div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Items per Category</h5>
                <div id="categoriesBarChart"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Items per Category (Custom Colors)</h5>
                <div id="categoriesCustomChart"></div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Latest Users</h5>
                <table class="table table-striped">
                    <thead>
                        <tr><th>Name</th><th>Email</th><th>Created</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($user->created_at)->diffForHumans()); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center">No users found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow p-4">
                <h5>Latest Items</h5>
                <table class="table table-striped">
                    <thead>
                        <tr><th>Title</th><th>Category</th><th>Created</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $latestItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->title); ?></td>
                            <td>
                                <?php echo e($item->category ? ($item->category->parent ? $item->category->parent->Category_Name.' > ' : '') . $item->category->Category_Name : 'N/A'); ?>

                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($item->created_at)->diffForHumans()); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center">No items found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@6.2.4/dist/simplebar.min.js"></script>
<script src="<?php echo e(asset('admin/js/plugins.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // -------------------
    // Users Per Month Chart
    // -------------------
    let months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    let usersData = Array(12).fill(0);

    <?php $__currentLoopData = $usersPerMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        usersData[<?php echo e($month-1); ?>] = <?php echo e($count); ?>;
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    const usersChart = new ApexCharts(document.querySelector("#usersChart"), {
        chart: { type: 'bar', height: 350 },
        series: [{ name: 'Users Registered', data: usersData }],
        xaxis: { categories: months },
        colors: ["#1cc88a"],
        plotOptions: { bar: { borderRadius: 6 } },
        dataLabels: { enabled: true }
    });
    usersChart.render();

    // -------------------
    // Items Added vs Modified Chart
    // -------------------
    const itemsChart = new ApexCharts(document.querySelector("#itemsChart"), {
        chart: { type: 'donut', height: 350 },
        series: [<?php echo e($itemsAdded ?? 0); ?>, <?php echo e($itemsModified ?? 0); ?>],
        labels: ['Added', 'Modified'],
        colors: ['#36b9cc', '#f6c23e'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true }
    });
    itemsChart.render();

    // -------------------
    // Items per Category Charts
    // -------------------
    let categoriesData = <?php echo json_encode($categoriesChartData, 15, 512) ?>;
    let categories = categoriesData.map(c => c.category);
    let categoriesCounts = categoriesData.map(c => parseInt(c.items_count));

    const categoriesBarChart = new ApexCharts(document.querySelector("#categoriesBarChart"), {
        chart: { type: 'bar', height: 400 },
        series: [{ name: 'Items per Category', data: categoriesCounts }],
        xaxis: { categories, labels: { rotate: -45 } },
        colors: ["#1cc88a"],
        plotOptions: { bar: { borderRadius: 6 } },
        dataLabels: { enabled: false }
    });
    categoriesBarChart.render();

    const categoriesCustomChart = new ApexCharts(document.querySelector("#categoriesCustomChart"), {
        chart: { type: 'bar', height: 400 },
        series: [{ name: 'Items per Category', data: categoriesCounts }],
        xaxis: { categories, labels: { rotate: -45 } },
        colors: categoriesCounts.map(() => `hsl(${Math.random() * 360},70%,60%)`),
        plotOptions: { bar: { borderRadius: 6, dataLabels: { position: 'top' } } },
        dataLabels: { enabled: true, formatter: val => val }
    });
    categoriesCustomChart.render();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/dashboard.blade.php ENDPATH**/ ?>