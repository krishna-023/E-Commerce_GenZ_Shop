@extends('web.layouts.master')

@section('content')
<div class="container my-5">
    <h3>Post a Banner</h3>
    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label for="category">Banner Category</label>
    <select name="category" id="category" class="form-control" required>
        <option value="">-- Select Category --</option>
        <option value="deals" {{ old('category', $banner->category ?? '') == 'deals' ? 'selected' : '' }}>Deals of the Day</option>
        <option value="recommended" {{ old('category', $banner->category ?? '') == 'recommended' ? 'selected' : '' }}>Recommended for You</option>
        <option value="latest" {{ old('category', $banner->category ?? '') == 'latest' ? 'selected' : '' }}>Latest Products</option>
    </select>
</div>

        <div class="mb-3">
            <label>Title (optional)</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label>Banner Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Link (optional)</label>
            <input type="url" name="link" class="form-control" value="{{ old('link') }}">
        </div>
        <button type="submit" class="btn btn-primary">Post Banner</button>
    </form>
</div>
@endsection
