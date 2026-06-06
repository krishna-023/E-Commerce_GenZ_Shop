@extends('web.layouts.master')

@section('title', $item->title ?? 'Product Details')

@section('css')
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
@endsection

@section('content')
<div class="container py-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('item.index') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item->title }}</li>
        </ol>
    </nav>

    <div class="row g-4">

        {{-- Left: Images --}}
        <div class="col-md-6">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid main-image" id="mainImage" alt="{{ $item->title }}">
            @endif

            {{-- Thumbnail gallery --}}
            @if($item->sellers && $item->sellers->count() > 0)
                <div class="row g-2 product-gallery mt-2">
                    @foreach($item->sellers as $seller)
                        @if($seller->gallery && is_array($seller->gallery))
                            @foreach($seller->gallery as $img)
                                <div class="col-3">
                                    <img src="{{ asset('storage/sellers/' . $img) }}" class="img-fluid" onclick="document.getElementById('mainImage').src=this.src" alt="Gallery Image">
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right: Product Info --}}
        <div class="col-md-6">
            <div class="product-labels mb-2">
                <span class="label-new">New</span>
                <span class="label-bestseller">Bestseller</span>
            </div>

            <h1>{{ $item->title }}</h1>
            <p class="text-muted">{{ $item->subtitle }}</p>

            {{-- Rating placeholder --}}
            <div class="rating mb-2">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="far fa-star"></i>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <span class="price">${{ $item->price ?? '0.00' }}</span>
                @if($item->actual_price)
                    <span class="actual-price">${{ $item->actual_price }}</span>
                @endif
                @if($item->discount_percentage)
                    <span class="discount">{{ $item->discount_percentage }}% OFF</span>
                @endif
            </div>

            <p><strong>Stock:</strong> {{ $item->stocks ?? 'N/A' }}</p>

            {{-- Quantity & Add to Cart / Buy --}}
            <div class="add-cart-buttons mb-4">
                <label for="quantity" class="form-label me-2">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control quantity-input" value="1" min="1">
                <div>
                    <button class="btn btn-primary"><i class="fas fa-shopping-cart me-1"></i> Add to Cart</button>
{{-- Buy Now --}}
<form action="{{ route('checkout.buyNow', $item->id) }}" method="GET" class="buy-now-form">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="btn btn-sm btn-success">Buy Now</button>
</form>
                </div>
            </div>

            {{-- Tabs --}}
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

                {{-- Description --}}
                <div class="tab-pane fade show active" id="description">
                    <p>{!! nl2br(e($item->description)) !!}</p>
                    <p><strong>Features:</strong> {!! nl2br(e($item->item_features)) !!}</p>
                </div>

                {{-- Specifications --}}
                <div class="tab-pane fade" id="specifications">
                    @if($item->specifications && $item->specifications->count() > 0)
                        <ul>
                            @foreach($item->specifications as $spec)
                                <li><strong>Size:</strong> {{ $spec->size ?? 'N/A' }}</li>
                                <li><strong>Weight:</strong> {{ $spec->weight ?? 'N/A' }}</li>
                                <li><strong>Height:</strong> {{ $spec->height ?? 'N/A' }}</li>
                                <li><strong>Width:</strong> {{ $spec->width ?? 'N/A' }}</li>
                                <li><strong>Thickness:</strong> {{ $spec->thickness ?? 'N/A' }}</li>
                                <li><strong>Color:</strong> {{ $spec->color ?? 'N/A' }}</li>
                                <li><strong>Quantity:</strong> {{ $spec->quantity ?? 'N/A' }}</li>
                                <li><strong>Details:</strong> {!! nl2br(e($spec->item_details)) !!}</li>
                                <hr>
                            @endforeach
                        </ul>
                    @else
                        <p>No specifications available.</p>
                    @endif
                </div>

                {{-- Sellers --}}
                <div class="tab-pane fade" id="sellers">
                    @if($item->sellers && $item->sellers->count() > 0)
                        @foreach($item->sellers as $seller)
                            <p><strong>Name:</strong> {{ $seller->seller_name }}</p>
                            <p><strong>Email:</strong> <a href="mailto:{{ $seller->seller_email }}">{{ $seller->seller_email }}</a></p>
                            <p><strong>Phone:</strong> <a href="tel:{{ $seller->seller_phone }}">{{ $seller->seller_phone }}</a></p>
                            <p><strong>Address:</strong> {{ $seller->seller_address }}</p>
                            <hr>
                        @endforeach
                    @else
                        <p>No sellers available.</p>
                    @endif
                </div>

                {{-- Gallery --}}
                <div class="tab-pane fade" id="gallery">
                    @if($item->sellers && $item->sellers->count() > 0)
                        <div class="row g-2 product-gallery">
                            @foreach($item->sellers as $seller)
                                @if($seller->gallery && is_array($seller->gallery))
                                    @foreach($seller->gallery as $img)
                                        <div class="col-3 mb-2">
                                            <img src="{{ asset('storage/sellers/' . $img) }}" class="img-fluid" onclick="document.getElementById('mainImage').src=this.src" alt="Gallery Image">
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p>No gallery images available.</p>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
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
@endsection
