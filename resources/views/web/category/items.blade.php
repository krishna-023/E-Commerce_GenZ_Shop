@extends('web.layouts.master') {{-- Use your existing layout --}}

@section('content')
<div class="container my-5">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">{{ $category->Category_Name }} Items</h2>
        <span class="badge bg-primary">{{ $items->total() }} items</span>
    </div>

    {{-- Items Grid --}}
    <div class="row g-4">
        @forelse($items as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 overflow-hidden rounded-3 position-relative">
                    {{-- Featured Badge --}}
                    @if($item->item_featured)
                        <span class="position-absolute top-0 start-0 bg-warning text-dark px-2 py-1 rounded-end fw-bold">
                            Featured
                        </span>
                    @endif

                    {{-- Item Image --}}
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $item->title }}">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($item->title, 40) }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($item->subtitle, 60) }}</p>
                        <a href="{{ route('item.view', encrypt($item->id)) }}" class="mt-auto btn btn-outline-primary btn-sm w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No items found in this category!
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

@push('styles')
<style>
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    }
    .object-fit-cover {
        object-fit: cover;
        width: 100%;
    }
</style>
@endpush
