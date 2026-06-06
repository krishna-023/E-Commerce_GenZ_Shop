@extends('admin.layouts.master')
@include('common.flash')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">📢 Active Banners</h2>
        <a href="{{ route('banners.create') }}" class="btn btn-primary">
            + Add Banner
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="card shadow rounded-3">
        <div class="card-body table-responsive">
            <table class="table align-middle table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Category</th> {{-- NEW --}}
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>
                            @if($banner->image)
                                <img src="{{ asset('storage/'.$banner->image) }}"
                                     alt="{{ $banner->title }}"
                                     class="img-thumbnail rounded"
                                     style="width: 120px; height: 60px; object-fit: cover;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $banner->title ?? 'Untitled' }}</td>
                        <td>{{ $banner->user?->name ?? 'N/A' }}</td>

                        {{-- Category Column --}}
                        <td>
                            @if($banner->category)
                                <span class="badge bg-primary">{{ $banner->category }}</span>
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </td>

                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $banner->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $banner->updated_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $banner->creator?->name ?? 'N/A' }}</td>
                        <td>{{ $banner->updater?->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('banners.show', $banner->id) }}"
                               class="btn btn-sm btn-info me-1">View</a>
                            <a href="{{ route('banners.edit', $banner->id) }}"
                               class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('banners.destroy', $banner->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this banner?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-muted">No active banners found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $banners->links() }}
    </div>
</div>
@endsection
