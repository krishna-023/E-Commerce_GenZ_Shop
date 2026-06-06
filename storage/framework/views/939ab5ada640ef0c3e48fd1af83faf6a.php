<?php $__env->startSection('title'); ?> Items List <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="flash-message"><?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>

<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Items <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> List <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-lg rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Items List</h5>
                <div>
                    <a href="<?php echo e(route('item.add')); ?>" class="btn btn-primary btn-sm">Add New Item</a>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Filter
                    </button>
                    <button id="deleteSelectedBtn" class="btn btn-danger btn-sm">Delete Selected</button>
                    <button id="exportSelectedBtn" class="btn btn-success btn-sm">Export Selected</button>
                </div>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="itemsearchbox" class="form-control" placeholder="Search items...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="datatable">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Stocks</th>
                                <th>Seller Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="<?php echo e($item->id); ?>"></td>
                                    <td><?php echo e($item->id); ?></td>
                                    <td><?php echo e($item->category->Category_Name ?? 'N/A'); ?></td>
                                    <td><?php echo e($item->title); ?></td>
                                    <td><?php echo e($item->subtitle); ?></td>
                                    <td><?php echo e($item->stocks); ?></td>
<td>
    <?php $__currentLoopData = $item->sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($seller->seller_name); ?><br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</td>                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?php echo e(route('item.view', encrypt($item->id))); ?>" class="btn btn-sm btn-secondary">view</a>
                                            <a href="<?php echo e(route('item.edit', encrypt($item->id))); ?>" class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="<?php echo e(route('item.destroy', encrypt($item->id))); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No items found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <?php echo $items->links('pagination::bootstrap-5'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="<?php echo e(route('item.index')); ?>">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->Category_Name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo e(request('title')); ?>">
            </div>
            <div class="mb-3">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="<?php echo e(request('subtitle')); ?>">
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    function updateButtonVisibility() {
        const anyChecked = $('.row-checkbox:checked').length > 0;
        $('#deleteSelectedBtn, #exportSelectedBtn').toggle(anyChecked);
    }

    // Check all
    $('#checkAll').click(function() {
        $('.row-checkbox').prop('checked', this.checked);
        updateButtonVisibility();
    });

    $('.row-checkbox').change(function() {
        const allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
        $('#checkAll').prop('checked', allChecked);
        updateButtonVisibility();
    });

    // Delete selected
    $('#deleteSelectedBtn').click(function() {
        const ids = $('.row-checkbox:checked').map(function(){ return $(this).val(); }).get();
        if(!ids.length) return Swal.fire('No items selected','Please select items','info');
        Swal.fire({
            title: 'Are you sure?',
            text: `Deleting ${ids.length} item(s)`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!'
        }).then((res) => {
            if(res.isConfirmed){
                $.post('<?php echo e(route("item.deleteSelected")); ?>', {_token:'<?php echo e(csrf_token()); ?>', ids: ids})
                 .done(r => Swal.fire('Deleted!', r.message, 'success').then(()=> location.reload()))
                 .fail(()=> Swal.fire('Error','Failed to delete','error'));
            }
        });
    });

    // Export selected
    $('#exportSelectedBtn').click(function() {
        const ids = $('.row-checkbox:checked').map(function(){ return $(this).val(); }).get();
        if(!ids.length) return Swal.fire('No items selected','Please select items','info');
        const form = $('<form>', {method:'POST', action:'<?php echo e(route("item.export")); ?>', target:'_blank'});
        ids.forEach(id => form.append(`<input type="hidden" name="ids[]" value="${id}">`));
        form.append(`<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">`);
        $('body').append(form); form.submit(); form.remove();
    });

    // Search box
    $('#itemsearchbox').on('keyup', function(){
        const val = $(this).val().toLowerCase();
        $('table tbody tr').filter(function(){ $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1) });
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/index.blade.php ENDPATH**/ ?>