@extends('web.layouts.master')
@section('title', 'Manage Item')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center">{{ isset($item) ? 'Edit Item' : 'Add New Item' }}</h3>
                    <form action="{{ isset($item) ? route('item.update', $item->id) : route('item.store') }}"
                          method="POST" enctype="multipart/form-data" id="itemForm">
                        @csrf
                        @if(isset($item)) @method('PUT') @endif

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('category_id', $item->category_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->Category_Name }}
                                    </option>
                                    @if($parent->children)
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ old('category_id', $item->category_id ?? '') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;— {{ $child->Category_Name }}
                                            </option>
                                            @if($child->children)
                                                @foreach($child->children as $grandchild)
                                                    <option value="{{ $grandchild->id }}"
                                                        {{ old('category_id', $item->category_id ?? '') == $grandchild->id ? 'selected' : '' }}>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;— {{ $grandchild->Category_Name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- Item Info --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Item Reference ID</label>
                                <input type="number" name="reference_id" class="form-control" value="{{ old('reference_id', $item->reference_id ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required value="{{ old('title', $item->title ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $item->subtitle ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Collection Date</label>
                                <input type="date" name="collection_date" class="form-control" value="{{ old('collection_date', isset($item->collection_date) ? $item->collection_date->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $item->price ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Actual Price</label>
                                <input type="number" step="0.01" name="actual_price" class="form-control" value="{{ old('actual_price', $item->actual_price ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Discount %</label>
                                <input type="number" step="0.01" name="discount_percentage" class="form-control" value="{{ old('discount_percentage', $item->discount_percentage ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Stocks</label>
                                <input type="number" name="stocks" class="form-control" value="{{ old('stocks', $item->stocks ?? '') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Image</label>
                                <input type="file" name="image" class="form-control">
                                <div id="itemImagePreview" class="mt-2">
                                    @if(isset($item) && $item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" style="max-width:150px" class="rounded">
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $item->description ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Item Features</label>
                                <textarea name="item_features" class="form-control" rows="3">{{ old('item_features', $item->item_features ?? '') }}</textarea>
                            </div>
                        </div>

   {{-- Seller Info --}}
<h5 class="mb-3">Seller Details</h5>
<div class="row g-3 mb-4">

    {{-- Toggle --}}
    <div class="col-12 mb-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="seller_option" id="existingSellerOption" value="existing" checked>
            <label class="form-check-label" for="existingSellerOption">Select Existing Seller</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="seller_option" id="newSellerOption" value="new">
            <label class="form-check-label" for="newSellerOption">Create New Seller</label>
        </div>
    </div>

    {{-- Existing Seller Dropdown --}}
    <div class="col-md-6" id="existingSellerDiv">
        <label class="form-label fw-bold">Select Seller <span class="text-danger">*</span></label>
        <select name="seller_id" class="form-select">
            <option value="">-- Select Seller --</option>
            @foreach($sellers as $s)
                <option value="{{ $s->id }}"
    @if(old('seller_id') == $s->id) selected
    @elseif(isset($item) && $item->sellers->first()?->id == $s->id) selected
    @endif>
    {{ $s->seller_name }}
</option>

            @endforeach
        </select>
    </div>

    {{-- New Seller Fields --}}
    <div class="col-md-6 d-none" id="newSellerDiv">
        <label class="form-label fw-bold">New Seller Name</label>
        <input type="text" name="seller_name_new" class="form-control" value="{{ old('seller_name_new') }}">
        <label class="form-label fw-bold mt-2">Email</label>
        <input type="email" name="seller_email_new" class="form-control" value="{{ old('seller_email_new') }}">
        <label class="form-label fw-bold mt-2">Phone</label>
        <input type="text" name="seller_phone_new" class="form-control" value="{{ old('seller_phone_new') }}">
        <label class="form-label fw-bold mt-2">Address</label>
        <input type="text" name="seller_address_new" class="form-control" value="{{ old('seller_address_new') }}">
        <label class="form-label fw-bold mt-2">Gallery Images</label>
        <input type="file" name="gallery[]" class="form-control" multiple>
        <div id="sellerGalleryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
    </div>
</div>

                        {{-- Specifications --}}
                        <h5 class="mb-3">Specifications</h5>
                        <div class="row g-3 mb-4">
                            @foreach(['size','weight','height','width','thickness','color','quantity'] as $field)
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">{{ ucfirst($field) }}</label>
                                    <input type="{{ $field == 'quantity' ? 'number' : 'text' }}" class="form-control" name="{{ $field }}" value="{{ old($field, $spec?->$field ?? '') }}">
                                </div>
                            @endforeach
                            <div class="col-12">
                                <label class="form-label fw-bold">Item Details</label>
                                <textarea class="form-control" name="item_details" rows="3">{{ old('item_details', $spec?->item_details ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Delivery --}}
                        <h5 class="mb-3">Delivery Info</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Delivery Type</label>
                                <input type="text" class="form-control" name="delivery_type" value="{{ old('delivery_type', $item->delivery_type ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Delivery Date</label>
                                <input type="date" class="form-control" name="delivery_date" value="{{ old('delivery_date', $item->delivery_date ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Delivery Charge</label>
                                <input type="number" class="form-control" name="delivery_charge" value="{{ old('delivery_charge', $item->delivery_charge ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Notes</label>
                                <textarea class="form-control" name="deliveryNote" rows="3">{{ old('deliveryNote', $item->deliveryNote ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg px-4">Save Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('itemForm');

    // ===== Item Image Preview =====
    const itemImageInput = document.querySelector('input[name="image"]');
    itemImageInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                document.getElementById('itemImagePreview').innerHTML = `<img src="${e.target.result}" style="max-width:150px" class="rounded">`;
            }
            reader.readAsDataURL(file);
        }
    });

    // ===== Seller Gallery Preview =====
    const sellerGalleryInput = document.querySelector('input[name="gallery[]"]');
    sellerGalleryInput?.addEventListener('change', function(e) {
        const container = document.getElementById('sellerGalleryPreview');
        container.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev){
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                img.classList.add('border','p-1','rounded');
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });

    // ===== SweetAlert2 Confirmation =====
    form.addEventListener('submit', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this item!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });

});
// Toggle Seller option
const existingSellerOption = document.getElementById('existingSellerOption');
const newSellerOption = document.getElementById('newSellerOption');
const existingSellerDiv = document.getElementById('existingSellerDiv');
const newSellerDiv = document.getElementById('newSellerDiv');

existingSellerOption.addEventListener('change', () => {
    if(existingSellerOption.checked){
        existingSellerDiv.classList.remove('d-none');
        newSellerDiv.classList.add('d-none');
    }
});
newSellerOption.addEventListener('change', () => {
    if(newSellerOption.checked){
        newSellerDiv.classList.remove('d-none');
        existingSellerDiv.classList.add('d-none');
    }
});

// Seller Gallery Preview (for new seller)
const sellerGalleryInput = document.querySelector('input[name="gallery[]"]');
sellerGalleryInput?.addEventListener('change', function(e){
    const container = document.getElementById('sellerGalleryPreview');
    container.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(ev){
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.style.maxWidth = '100px';
            img.style.maxHeight = '100px';
            img.classList.add('border','p-1','rounded');
            container.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});

</script>
@endsection
