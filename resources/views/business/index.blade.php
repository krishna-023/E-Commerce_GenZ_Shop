@extends('layouts.app')

@section('content')
    <h2>Business Listings</h2>
    <div class="row">
        @foreach($businesses as $business)
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ asset($business->image) }}" class="card-img-top" alt="{{ $business->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $business->title }}</h5>
                        <p class="card-text">{{ Str::limit($business->description, 100) }}</p>
                        <a href="{{ route('business.show', $business->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
