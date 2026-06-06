@extends('admin.layouts.master')

@section('title', 'View Item')

@section('css')
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
@endsection

@section('content')
<div class="container py-5">

    <div class="row">

        {{-- Left: Product Image --}}
        <div class="col-md-6">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid main-image" id="mainImage" alt="{{ $item->title }}">
            @endif

            {{-- Gallery Thumbnails --}}
            @if($item->sellers && $item->sellers->count() > 0)
                <div class="row g-2 product-gallery mt-2">
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
            @endif
        </div>

        {{-- Right: Product Info + Tabs --}}
        <div class="col-md-6">
            <h2>{{ $item->title }}</h2>
            <p class="text-muted">{{ $item->subtitle }}</p>
            <p><strong>Price:</strong> {{ $item->price ?? 'N/A' }} | <strong>Actual Price:</strong> {{ $item->actual_price ?? 'N/A' }}</p>
            <p><strong>Discount:</strong> {{ $item->discount_percentage ?? '0' }}%</p>
            <p><strong>Stocks:</strong> {{ $item->stocks ?? 'N/A' }}</p>

            {{-- Tabs --}}
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

                {{-- Description Tab --}}
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <p>{!! nl2br(e($item->description)) !!}</p>
                    <p><strong>Item Features:</strong> {!! nl2br(e($item->item_features)) !!}</p>
                </div>

                {{-- Sellers Tab --}}
                <div class="tab-pane fade" id="sellers" role="tabpanel">
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

                {{-- Specifications Tab --}}
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    @if($item->specifications && $item->specifications->count() > 0)
                        @foreach($item->specifications as $spec)
                            <ul>
                                <li><strong>Size:</strong> {{ $spec->size ?? 'N/A' }}</li>
                                <li><strong>Weight:</strong> {{ $spec->weight ?? 'N/A' }}</li>
                                <li><strong>Height:</strong> {{ $spec->height ?? 'N/A' }}</li>
                                <li><strong>Width:</strong> {{ $spec->width ?? 'N/A' }}</li>
                                <li><strong>Thickness:</strong> {{ $spec->thickness ?? 'N/A' }}</li>
                                <li><strong>Color:</strong> {{ $spec->color ?? 'N/A' }}</li>
                                <li><strong>Quantity:</strong> {{ $spec->quantity ?? 'N/A' }}</li>
                                <li><strong>Details:</strong> {!! nl2br(e($spec->item_details)) !!}</li>
                            </ul>
                            <hr>
                        @endforeach
                    @else
                        <p>No specifications available.</p>
                    @endif
                </div>

                {{-- Gallery Tab --}}
                <div class="tab-pane fade" id="gallery" role="tabpanel">
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

            <a href="{{ route('item.index') }}" class="btn btn-primary mt-3">Back to List</a>

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
</script>
@endsection
