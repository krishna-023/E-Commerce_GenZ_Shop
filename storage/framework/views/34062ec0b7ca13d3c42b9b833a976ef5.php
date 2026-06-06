<?php $__env->startSection('title', 'Manage Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="flash-message">
    <?php echo $__env->make('common.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Items <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Add / Edit Item <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php
    $item = $item ?? null;
    $seller = $item?->sellers->first() ?? null;
    $spec = $item?->specifications->first() ?? null;
    $categoryMode = isset($item) && $item->category_name ? 'new_category' : 'select_category';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body form-steps">
                    <form action="<?php echo e(isset($item) ? route('item.update', $item->id) : route('item.store')); ?>"
                          method="POST" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php if(isset($item)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                        <div class="row gy-5">
                            <div class="col-lg-3">
                                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#step-item">Item</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#step-seller">Seller</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#step-spec">Specification</button>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="tab-content">

                                    
                                    <div class="tab-pane fade show active" id="step-item">
                                        <h5>Item Details</h5>
                                        <div class="row g-3">

                                            <div class="col-sm-6">
                                                <div class="mb-2">
                                                    <input type="radio" name="category_mode"
                                                        value="select_category" id="radio_select"
                                                        onclick="toggleCategoryMode()" <?php echo e($categoryMode == 'select_category' ? 'checked' : ''); ?>>
                                                    <label for="radio_select">Select From Category List</label>

                                                    <input type="radio" name="category_mode"
                                                        value="new_category" id="radio_new"
                                                        onclick="toggleCategoryMode()" <?php echo e($categoryMode == 'new_category' ? 'checked' : ''); ?>>
                                                    <label for="radio_new">Create New</label>
                                                </div>

                                                
                                                <div id="category_select_div" style="display:none;">
                                                    <label for="category_id_select" class="form-label">Parent Category</label>
                                                    <select id="category_id_select" name="category_id" class="form-select">
                                                        <option value="">-- Select Category --</option>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($parent->id); ?>"
                                                                <?php echo e(old('category_id', $item->category_id ?? '') == $parent->id ? 'selected' : ''); ?>>
                                                                <?php echo e($parent->Category_Name); ?>

                                                            </option>

                                                            <?php if($parent->children): ?>
                                                                <?php $__currentLoopData = $parent->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($child->id); ?>"
                                                                        <?php echo e(old('category_id', $item->category_id ?? '') == $child->id ? 'selected' : ''); ?>>
                                                                        &nbsp;&nbsp;— <?php echo e($child->Category_Name); ?>

                                                                    </option>
                                                                    <?php if($child->children): ?>
                                                                        <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grandchild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($grandchild->id); ?>"
                                                                                <?php echo e(old('category_id', $item->category_id ?? '') == $grandchild->id ? 'selected' : ''); ?>>
                                                                                &nbsp;&nbsp;&nbsp;&nbsp;— <?php echo e($grandchild->Category_Name); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                
                                                <div id="category_new_div" style="display:none;">
                                                    <label for="category_name" class="form-label">New Parent Category</label>
                                                    <input type="text" name="category_name" id="category_name"
                                                        class="form-control mb-2"
                                                        placeholder="Enter parent category name" value="<?php echo e(old('category_name', $item->category_name ?? '')); ?>">

                                                    <label for="child_category_name" class="form-label">New Child Category (optional)</label>
                                                    <input type="text" name="child_category_name"
                                                        id="child_category_name" class="form-control"
                                                        placeholder="Enter child category name" value="<?php echo e(old('child_category_name', $item->child_category_name ?? '')); ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="reference_id" class="form-label">Item Reference ID</label>
                                                <input type="number" class="form-control" id="reference_id" name="reference_id"
                                                       value="<?php echo e(old('reference_id', $item->reference_id ?? '')); ?>">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control" required
                                                       value="<?php echo e(old('title', $item->title ?? '')); ?>">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Subtitle</label>
                                                <input type="text" name="subtitle" class="form-control"
                                                       value="<?php echo e(old('subtitle', $item->subtitle ?? '')); ?>">
                                            </div>

                                            <div class="col-12">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control"><?php echo e(old('description', $item->description ?? '')); ?></textarea>
                                            </div>

                                            <div class="col-12">
                                                <label>Item Features</label>
                                                <textarea name="item_features" class="form-control"><?php echo e(old('item_features', $item->item_features ?? '')); ?></textarea>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Collection Date</label>
                                                <input type="date" name="collection_date" class="form-control"
                                                       value="<?php echo e(old('collection_date', isset($item->collection_date) ? $item->collection_date->format('Y-m-d') : '')); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Price</label>
                                                <input type="number" step="0.01" min="0" name="price" class="form-control"
                                                       value="<?php echo e(old('price', $item->price ?? '')); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Actual Price</label>
                                                <input type="number" step="0.01" min="0" name="actual_price" class="form-control"
                                                       value="<?php echo e(old('actual_price', $item->actual_price ?? '')); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Discount Percentage</label>
                                                <input type="number" step="0.01" min="0" name="discount_percentage" class="form-control"
                                                       value="<?php echo e(old('discount_percentage', $item->discount_percentage ?? '')); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Stocks</label>
                                                <input type="number" min="0" name="stocks" class="form-control"
                                                       value="<?php echo e(old('stocks', $item->stocks ?? '')); ?>">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control">
                                                <?php if(isset($item->image)): ?>
                                                    <img src="<?php echo e(asset('storage/' . $item->image)); ?>" style="max-width:150px;" class="mt-2" id="itemImagePreview">
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    </div>

                                    
<div class="tab-pane fade" id="step-seller">
    <h5>Seller Details</h5>
    <div class="row g-3">

        
        <div class="col-md-6">
            <label for="seller_id" class="form-label">Select Seller</label>
            <div class="input-group">
                <select id="seller_id" name="seller_id" class="form-select">
                    <option value="">-- Select Seller --</option>
                    <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>" <?php echo e(($seller && $seller->id==$s->id) ? 'selected' : ''); ?>>
                            <?php echo e($s->seller_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="button" class="btn btn-outline-primary" id="addNewSellerBtn">New</button>
            </div>
        </div>

        
        <div class="col-md-6" id="newSellerFields" style="display: none;">
            <label class="form-label">Seller Name</label>
            <input type="text" class="form-control mb-2" name="seller_name_new" placeholder="Enter new seller name">

            <label class="form-label">Seller Email</label>
            <input type="email" class="form-control mb-2" name="seller_email_new" placeholder="Enter new seller email">

            <label class="form-label">Seller Phone</label>
            <input type="text" class="form-control mb-2" name="seller_phone_new" placeholder="Enter new seller phone">

            <label class="form-label">Seller Address</label>
            <input type="text" class="form-control" name="seller_address_new" placeholder="Enter new seller address">
        </div>

        
        <div class="col-md-6">
            <label class="form-label">Gallery Images</label>
            <input type="file" class="form-control" name="gallery[]" multiple>
            <?php if(isset($item->gallery)): ?>
                <div id="sellerGalleryPreview" class="mt-2 d-flex gap-2 flex-wrap">
                    <?php $__currentLoopData = $item->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $galleryImage->image_path)); ?>" style="max-width:100px; max-height:100px;" class="border p-1 rounded">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


                                    
                                    <div class="tab-pane fade" id="step-spec">
                                        <h5>Specifications</h5>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label>Size</label>
                                                <input type="text" class="form-control" name="size"
                                                       value="<?php echo e(old('size', $spec?->size ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Weight</label>
                                                <input type="text" class="form-control" name="weight"
                                                       value="<?php echo e(old('weight', $spec?->weight ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Height</label>
                                                <input type="text" class="form-control" name="height"
                                                       value="<?php echo e(old('height', $spec?->height ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Width</label>
                                                <input type="text" class="form-control" name="width"
                                                       value="<?php echo e(old('width', $spec?->width ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Thickness</label>
                                                <input type="text" class="form-control" name="thickness"
                                                       value="<?php echo e(old('thickness', $spec?->thickness ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Color</label>
                                                <input type="text" class="form-control" name="color"
                                                       value="<?php echo e(old('color', $spec?->color ?? '')); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" name="quantity"
                                                       value="<?php echo e(old('quantity', $spec?->quantity ?? '')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label>Item Details</label>
                                                <textarea class="form-control" name="item_details" rows="4"><?php echo e(old('item_details', $spec?->item_details ?? '')); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- tab-content -->
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success">Save Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const tabs = Array.from(document.querySelectorAll('.tab-pane'));
    const navLinks = Array.from(document.querySelectorAll('.nav-link'));
    let currentTabIndex = 0;

    function showTab(index){
        tabs.forEach((tab,i) => {
            tab.classList.remove('show','active');
            navLinks[i].classList.remove('active');
            if(i===index){ tab.classList.add('show','active'); navLinks[i].classList.add('active'); }
        });
        currentTabIndex = index;
    }

    // Next / Previous Buttons
    tabs.forEach((tab,i) => {
        const btnContainer = document.createElement('div');
        btnContainer.classList.add('mt-3','text-end');

        if(i>0){
            const prevBtn = document.createElement('button');
            prevBtn.type='button'; prevBtn.classList.add('btn','btn-secondary','me-2'); prevBtn.textContent='Previous';
            prevBtn.addEventListener('click',()=>showTab(i-1));
            btnContainer.appendChild(prevBtn);
        }

        if(i<tabs.length-1){
            const nextBtn = document.createElement('button');
            nextBtn.type='button'; nextBtn.classList.add('btn','btn-primary'); nextBtn.textContent='Next';
            nextBtn.addEventListener('click',()=>{
                if(validateTab(tabs[i])) showTab(i+1);
            });
            btnContainer.appendChild(nextBtn);
        }
        tab.appendChild(btnContainer);
    });

    function validateTab(tab){
        const requiredFields = tab.querySelectorAll('[required]');
        let valid=true;
        requiredFields.forEach(f=>{
            if(!f.value.trim()){ f.classList.add('is-invalid'); valid=false; } else { f.classList.remove('is-invalid'); }
        });
        return valid;
    }

    // Image Preview
    const itemImageInput = document.querySelector('input[name="image"]');
    itemImageInput?.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(ev){
                let preview = document.getElementById('itemImagePreview');
                if(!preview){
                    preview = document.createElement('img');
                    preview.id='itemImagePreview';
                    preview.style.maxWidth='150px';
                    preview.classList.add('mt-2');
                    itemImageInput.parentNode.appendChild(preview);
                }
                preview.src = ev.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    const sellerGalleryInput = document.querySelector('input[name="gallery[]"]');
    sellerGalleryInput?.addEventListener('change', function(e){
        let container = document.getElementById('sellerGalleryPreview');
        if(!container){
            container = document.createElement('div'); container.id='sellerGalleryPreview';
            container.classList.add('mt-2','d-flex','gap-2','flex-wrap'); sellerGalleryInput.parentNode.appendChild(container);
        }
        container.innerHTML='';
        Array.from(e.target.files).forEach(file=>{
            const reader = new FileReader();
            reader.onload=function(ev){
                const img=document.createElement('img');
                img.src=ev.target.result; img.style.maxWidth='100px'; img.style.maxHeight='100px';
                img.classList.add('border','p-1','rounded'); container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });

    // SweetAlert
    form.addEventListener('submit', function(e){
        e.preventDefault();
        if(!validateTab(tabs[currentTabIndex])) return;
        Swal.fire({
            title:'Are you sure?',
            text:'You want to save this item!',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#3085d6',
            cancelButtonColor:'#d33',
            confirmButtonText:'Yes, save it!'
        }).then(result=>{
            if(result.isConfirmed) form.submit();
        });
    });

    // Unsaved changes warning
    let isFormChanged=false;
    form.addEventListener('change',()=>{isFormChanged=true;});
    window.addEventListener('beforeunload', (e)=>{if(isFormChanged){e.preventDefault(); e.returnValue='';}});

    // Toggle Category Mode
    toggleCategoryMode();
});

function toggleCategoryMode(){
    const selectDiv=document.getElementById('category_select_div');
    const newDiv=document.getElementById('category_new_div');
    const mode=document.querySelector('input[name="category_mode"]:checked').value;
    if(mode==='select_category'){ selectDiv.style.display='block'; newDiv.style.display='none'; }
    else{ selectDiv.style.display='none'; newDiv.style.display='block'; }
}
document.addEventListener('DOMContentLoaded', function () {
    const addNewSellerBtn = document.getElementById('addNewSellerBtn');
    const newSellerFields = document.getElementById('newSellerFields');
    const sellerSelect = document.getElementById('seller_id');

    addNewSellerBtn?.addEventListener('click', function () {
        if (newSellerFields.style.display === 'none') {
            newSellerFields.style.display = 'block';
            sellerSelect.value = ''; // reset existing seller dropdown
        } else {
            newSellerFields.style.display = 'none';
        }
    });
});
sellerSelect?.addEventListener('change', function () {
    if (sellerSelect.value) {
        newSellerFields.style.display = 'none';
    }
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/items/add.blade.php ENDPATH**/ ?>