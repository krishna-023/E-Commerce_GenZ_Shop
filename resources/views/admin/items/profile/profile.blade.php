@extends('web.layouts.master')

@section('title')
    @lang('translation.profile')
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Pages @endslot
    @slot('title') Profile @endslot
@endcomponent

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger shadow-sm rounded">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    {{-- Left Sidebar Profile Card --}}
    <div class="col-xl-3">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-body text-center p-4">
                <div class="position-relative d-inline-block">
                    <img
                        id="profilePreview"
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                        alt="Profile Picture"
                        class="img-thumbnail rounded-circle shadow"
                        style="width: 160px; height: 160px; object-fit: cover; border: 5px solid #f8f9fa;">
                    <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-primary text-white rounded-circle shadow">
                        <i class="fa fa-camera"></i>
                    </span>
                </div>
                <h4 class="mt-3 mb-1 fw-bold">{{ Auth::user()->name }}</h4>
                <p class="text-muted small mb-2"><i class="fa fa-envelope me-1"></i> {{ Auth::user()->email }}</p>
                <span class="badge bg-success px-3 py-2 rounded-pill">Active User</span>
            </div>
        </div>

        {{-- Profile Picture Update Form --}}
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 fw-bold"><i class="fa fa-camera me-2"></i> Update Profile Picture</h5>
                <form action="{{ route('profile.picture.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <input type="file" class="form-control" name="profile_picture" id="profile_picture_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fa fa-save me-2"></i> Update Picture
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Profile Settings --}}
    <div class="col-xl-9">
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <h5 class="mb-0"><i class="fa fa-user-cog me-2"></i> Profile Settings</h5>
            </div>
            <div class="card-body p-4">
<form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username"
                                   value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                   value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Change Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                   placeholder="Leave blank if unchanged">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                   name="password_confirmation" placeholder="Leave blank if unchanged">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-lg btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fa fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Super Admin Add User --}}
        @if(Auth::user()->role === 'super-admin')
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <h5 class="mb-0 fw-bold"><i class="fa fa-users me-2"></i> Add New User</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-success btn-lg rounded-pill shadow-sm">
                        <i class="fa fa-user-plus me-2"></i> Add User
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('admin/js/app.js') }}"></script>
<script>
    // Preview for profile picture upload
    document.getElementById('profile_picture_file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

</script>
@endsection
