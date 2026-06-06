@extends('layouts.app')

@section('content')
    <div class="card">
        <img src="{{ asset($business->image) }}" class="card-img-top" alt="{{ $business->title }}">
        <div class="card-body">
            <h2>{{ $business->title }}</h2>
            <p>{{ $business->description }}</p>
            <p><strong>Contact:</strong> {{ $business->contact }}</p>
            <p><strong>Opening Hours:</strong> {{ $business->opening_hours }}</p>
        </div>
    </div>
@endsection
