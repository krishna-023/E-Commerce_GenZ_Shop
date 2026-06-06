<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-user-cog me-2"></i> Profile Settings</h5>
    <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{ $user->name }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank if unchanged">
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank if unchanged">
            </div>
            <div class="col-12">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control" accept="image/*">
            </div>
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary rounded-pill">Save Changes</button>
        </div>
    </form>
</div>
