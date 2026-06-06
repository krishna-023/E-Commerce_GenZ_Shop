<div class="col-md-4 col-lg-3">
    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-scale">
        @php
            $gallery = $item->galleries->first();
            $imagePath = $gallery ? (is_array(json_decode($gallery->gallery)) ? json_decode($gallery->gallery)[0] : $gallery->gallery) : $item->image;
        @endphp
        <img src="{{ $imagePath ? asset('storage/' . $imagePath) : asset('images/no-image.png') }}" class="card-img-top" alt="{{ $item->title }}">
        <div class="card-body d-flex flex-column">
            <h6 class="card-title fw-bold">{{ $item->title }}</h6>
            <p class="card-text text-muted mb-2">{{ Str::limit($item->subtitle ?? $item->content, 60) }}</p>
            <p class="mb-1"><i class="bi bi-tag-fill me-1"></i>{{ $item->category->Category_Name ?? '-' }}</p>
            <p class="mb-1"><i class="bi bi-telephone-fill me-1"></i>{{ $item->contacts->first()->telephone ?? '-' }}</p>
            <a href="{{ route('item.view', encrypt($item->id)) }}" class="btn btn-outline-primary mt-auto rounded-pill">View Details</a>
        </div>
    </div>
</div>
