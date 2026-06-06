<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-credit-card me-2"></i> eSewa / Payments</h5>
    <form action="{{ route('account.payment.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">eSewa ID</label>
            <input type="text" name="esewa_id" value="{{ $user->esewa_id ?? '' }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success rounded-pill">Link eSewa</button>
    </form>
</div>
