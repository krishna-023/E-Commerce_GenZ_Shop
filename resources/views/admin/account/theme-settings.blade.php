<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-adjust me-2"></i> Theme</h5>
    <form action="{{ route('account.theme.save') }}" method="POST">
        @csrf
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="theme" value="light" id="themeLight" {{ $theme === 'light' ? 'checked' : '' }}>
            <label class="form-check-label" for="themeLight">Light Mode</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="theme" value="dark" id="themeDark" {{ $theme === 'dark' ? 'checked' : '' }}>
            <label class="form-check-label" for="themeDark">Dark Mode</label>
        </div>
        <button type="submit" class="btn btn-secondary rounded-pill">Save Theme</button>
    </form>
</div>
