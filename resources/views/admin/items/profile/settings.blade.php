@extends('admin.layouts.master')

@section('title', 'Profile Settings')

@section('content')
@php
    $user = isset($editUser) ? $editUser : Auth::user(); // User being edited
    $currentUser = Auth::user(); // Logged-in user

    // Can the logged-in user edit role/permissions?
    $canEditRoles = $currentUser->role === 'super-admin' || ($currentUser->role === 'admin' && $user->role !== 'super-admin');

    // Ensure permissions are an array
    $userPermissions = is_array($user->permissions) ? $user->permissions : json_decode($user->permissions, true) ?? [];
@endphp

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

@component('components.breadcrumb')
    @slot('li_1') Pages @endslot
    @slot('title') Profile @endslot
@endcomponent

<div class="row">
    <!-- Profile Picture -->
    <div class="col-xl-3">
        <div class="card mb-4 text-center">
            <div class="card-body">
                <img id="profilePreview"
                     src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.png') }}"
                     alt="Profile Picture"
                     class="img-thumbnail rounded-circle mb-3"
                     style="width: 150px; height: 150px; object-fit: cover;">
                <h5>{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
    </div>

    <!-- Profile Settings -->
    <div class="col-xl-9">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Profile Settings</h5>
                <form action="{{ $canEditRoles ? route('user.update', $user->id) : route('profile.settings.update') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($canEditRoles)
                        @method('PUT')
                    @endif

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="{{ old('username', $user->name) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Leave blank to keep current">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" placeholder="Leave blank to keep current">
                    </div>

                    <!-- Profile Picture -->
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>

                    <!-- Role & Permissions (Super-admin / Admin Editing Allowed Users) -->
                    @if($canEditRoles)
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach(['user','admin','super-admin'] as $roleOption)
                                    @if($currentUser->role === 'admin' && $roleOption === 'super-admin')
                                        @continue
                                    @endif
                                    <option value="{{ $roleOption }}" @selected($user->role === $roleOption)>{{ ucfirst($roleOption) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permissions -->
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach(config('role_permissions.permissions') as $category => $perms)
                                    <div class="card card-body p-2 mb-2">
                                        <strong>{{ $category }}</strong>
                                        <div class="d-flex flex-wrap gap-3 mt-1">
                                            @foreach($perms as $perm)
                                                @php
                                                    $canAssignPerm = $currentUser->role === 'super-admin'
                                                                     || ($currentUser->role === 'admin' && in_array($perm, config('role_permissions.roles.admin')));
                                                @endphp

                                                @if($canAssignPerm)
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $perm }}"
                                                               id="perm_{{ $perm }}"
                                                               @checked(in_array($perm, $userPermissions))>
                                                        <label class="form-check-label" for="perm_{{ $perm }}">
                                                            {{ ucfirst(str_replace(['.', '_'], ' ', $perm)) }}
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add User (Admin / Super-admin) -->
    @if($currentUser->role === 'admin' || $currentUser->role === 'super-admin')
        <div class="col-xl-9">
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Manage Users</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-success">+ Add User</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
<script src="{{ asset('admin/js/app.js') }}"></script>
<script>
    document.getElementById('profile_picture')?.addEventListener('change', function (event) {
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
