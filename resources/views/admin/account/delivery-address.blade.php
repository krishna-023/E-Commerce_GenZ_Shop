<div class="card shadow-lg border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-3"><i class="fa fa-map-marker-alt me-2"></i> Delivery Address</h5>
    <form action="{{ route('account.address.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Label (Home, Work, etc.)</label>
            <input type="text" class="form-control" name="label" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
        </div>
        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="city" required>
        </div>
        <div class="mb-3">
            <label class="form-label">ZIP / Postal Code</label>
            <input type="text" class="form-control" name="zip">
        </div>
        <button type="submit" class="btn btn-primary rounded-pill">Save Address</button>
    </form>

    @if(!empty($addresses))
    <hr>
    <h6 class="fw-bold">Saved Addresses</h6>
    <ul class="list-group">
        @foreach($addresses as $addr)
        <li class="list-group-item">
            <strong>{{ $addr['label'] }}:</strong> {{ $addr['address'] }}, {{ $addr['city'] }} {{ $addr['zip'] ?? '' }}
        </li>
        @endforeach
    </ul>
    @endif
</div>
