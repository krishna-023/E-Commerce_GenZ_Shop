@extends('admin.layouts.master-without-nav')

@section('title', 'Account Settings')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Pages @endslot
    @slot('title') Account Settings @endslot
@endcomponent

<div class="row">
    <div class="col-xl-3">
        {{-- Sidebar Profile Card --}}
        <div class="card shadow-lg border-0 rounded-4 mb-4 text-center p-3">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                 alt="Profile" class="img-thumbnail rounded-circle mb-3" style="width:120px;height:120px;">
            <h5 class="fw-bold">{{ Auth::user()->name }}</h5>
            <p class="text-muted small">{{ Auth::user()->email }}</p>
        </div>

        {{-- Sidebar Tabs --}}
        <div class="list-group shadow-lg rounded-4">
            <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">Profile Settings</a>
            <a href="#delivery" class="list-group-item list-group-item-action" data-bs-toggle="tab">Delivery Address</a>
            <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="tab">eSewa / Payments</a>
            <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="tab">Notifications</a>
            <a href="#theme" class="list-group-item list-group-item-action" data-bs-toggle="tab">Theme</a>
        </div>
    </div>

    <div class="col-xl-9">
        <div class="tab-content">

            {{-- Profile Settings --}}
            <div class="tab-pane fade show active" id="profile">
                @include('admin.account.profile-settings')
            </div>

            {{-- Delivery Address --}}
            <div class="tab-pane fade" id="delivery">
                @include('admin.account.delivery-address')
            </div>

            {{-- Payment / eSewa --}}
            <div class="tab-pane fade" id="payment">
                @include('admin.account.payment-settings')
            </div>

            {{-- Notifications --}}
            <div class="tab-pane fade" id="notifications">
                @include('admin.account.notifications')
            </div>

            {{-- Theme --}}
            <div class="tab-pane fade" id="theme">
                @include('admin.account.theme-settings')
            </div>

        </div>
    </div>
</div>
@endsection
