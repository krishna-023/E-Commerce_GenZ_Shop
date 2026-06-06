<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-bell me-2"></i> Notifications</h5>
    <form action="{{ route('account.notifications.save') }}" method="POST">
        @csrf
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="notifications[email]" id="notifyEmail" value="1" {{ $notifications['email'] ?? false ? 'checked' : '' }}>
            <label class="form-check-label" for="notifyEmail">Email Notifications</label>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="notifications[sms]" id="notifySMS" value="1" {{ $notifications['sms'] ?? false ? 'checked' : '' }}>
            <label class="form-check-label" for="notifySMS">SMS Notifications</label>
        </div>
        <button type="submit" class="btn btn-primary rounded-pill">Save Notifications</button>
    </form>
</div>
