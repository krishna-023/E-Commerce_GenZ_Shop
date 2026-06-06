@extends('admin.layouts.master')

@section('title', isset($user) ? 'Edit User' : 'Add New User')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h5>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($user) ? route('profile.settings.update', $user->id) : route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label">{{ isset($user) ? 'Change Password (optional)' : 'Password' }}</label>
                <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
            </div>

            {{-- Role Selection --}}
            @if(Auth::user()->role !== 'user')
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    @if(Auth::user()->role === 'super-admin')
                        <option value="super-admin" {{ old('role', $user->role ?? '') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                    @endif
                </select>
            </div>
            @endif

            {{-- Permissions --}}
@if(isset($permissions) && count($permissions) > 0 && Auth::user()->role !== 'user')
<div class="mb-3">
    <label class="form-label">Permissions</label>
    <div class="accordion" id="permissionsAccordion">
        @foreach(config('role_permissions.permissions') as $category => $perms)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{ Str::slug($category) }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($category) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($category) }}">
                        {{ $category }}
                    </button>
                </h2>
                <div id="collapse-{{ Str::slug($category) }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ Str::slug($category) }}" data-bs-parent="#permissionsAccordion">
                    <div class="accordion-body">
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($perms as $perm)
                                @php
                                    $checked = isset($user) && in_array($perm, $user->permissions ?? []) ? 'checked' : '';
                                @endphp
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $perm }}" id="perm_{{ Str::slug($perm) }}" {{ $checked }}>
                                    <label class="form-check-label" for="perm_{{ Str::slug($perm) }}">
                                        {{ ucfirst(str_replace(['_', '.'], [' ', ' '], $perm)) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif


            {{-- Profile Picture --}}
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control" accept="image/*">
                @if(isset($user) && $user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" class="img-thumbnail mt-2" style="width:120px; height:120px; object-fit:cover;">
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update User' : 'Add User' }}</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    const profileInput = document.querySelector('input[name="profile_picture"]');
    if(profileInput){
        profileInput.addEventListener('change', function(e){
            const reader = new FileReader();
            reader.onload = function(e){
                let img = document.querySelector('.img-thumbnail');
                if(img) img.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
    }
</script>
@endsection
