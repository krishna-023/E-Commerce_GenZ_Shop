@extends('web.layouts.master')

@section('title', $category->Category_Name . ' | Shop')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">🛍️ {{ $category->Category_Name }}</h3>

    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-md-3 col-sm-6">
                <div class="product-card">
                    @if($item->discount_percentage)
                        <div class="badge-discount">{{ $item->discount_percentage }}% OFF</div>
                    @endif
                    <a href="{{ route('item.view', $item->id) }}">
                        <img src="{{ asset('storage/' . ($item->image ?? 'no-image.png')) }}" alt="{{ $item->title }}">
                    </a>
                    <div class="card-body">
                        <h6>{{ $item->title }}</h6>
                        <div class="rating">★★★★★</div>
                        <p>
                            <span class="product-price">{{ $item->price ?? 'N/A' }}</span>
                            @if($item->actual_price)
                                <span class="product-old-price">{{ $item->actual_price }}</span>
                            @endif
                        </p>
                        <button class="btn btn-sm btn-success quick-add">Quick Add</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found in this category.</p>
        @endforelse
    </div>
</div>
@endsection
