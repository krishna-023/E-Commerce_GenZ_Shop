@extends('admin.layouts.master')
@include('common.flash')
@section('content')
<div class="container">
    <h2>Banner Details</h2>

    <p><strong>Title:</strong> {{ $banner->title }}</p>
    <p><strong>Link:</strong> <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></p>
    <p><strong>Created By:</strong> {{ $banner->creator?->name ?? 'N/A' }}</p>
    <p><strong>Updated By:</strong> {{ $banner->updater?->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $banner->is_active ? 'Active' : 'Inactive' }}</p>

    @if($banner->image)
        <img src="{{ asset('storage/'.$banner->image) }}" alt="Banner" class="img-fluid my-3" width="400">
    @endif

    <a href="{{ route('banners.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
