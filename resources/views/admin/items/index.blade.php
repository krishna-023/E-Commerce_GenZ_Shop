@extends('admin.layouts.master')
@section('title') Items List @endsection

@section('content')
<div class="flash-message">@include('common.flash')</div>

@component('components.breadcrumb')
    @slot('li_1') Items @endslot
    @slot('title') List @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card shadow-lg rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Items List</h5>
                <div>
                    <a href="{{ route('item.add') }}" class="btn btn-primary btn-sm">Add New Item</a>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Filter
                    </button>
                    <button id="deleteSelectedBtn" class="btn btn-danger btn-sm">Delete Selected</button>
                    <button id="exportSelectedBtn" class="btn btn-success btn-sm">Export Selected</button>
                </div>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="itemsearchbox" class="form-control" placeholder="Search items...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="datatable">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Stocks</th>
                                <th>Seller Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="{{ $item->id }}"></td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->category->Category_Name ?? 'N/A' }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->subtitle }}</td>
                                    <td>{{ $item->stocks }}</td>
<td>
    @foreach($item->sellers as $seller)
        {{ $seller->seller_name }}<br>
    @endforeach
</td>                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('item.view', encrypt($item->id)) }}" class="btn btn-sm btn-secondary">view</a>
                                            <a href="{{ route('item.edit', encrypt($item->id)) }}" class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="{{ route('item.destroy', encrypt($item->id)) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {!! $items->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('item.index') }}">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->Category_Name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ request('title') }}">
            </div>
            <div class="mb-3">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ request('subtitle') }}">
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    function updateButtonVisibility() {
        const anyChecked = $('.row-checkbox:checked').length > 0;
        $('#deleteSelectedBtn, #exportSelectedBtn').toggle(anyChecked);
    }

    // Check all
    $('#checkAll').click(function() {
        $('.row-checkbox').prop('checked', this.checked);
        updateButtonVisibility();
    });

    $('.row-checkbox').change(function() {
        const allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
        $('#checkAll').prop('checked', allChecked);
        updateButtonVisibility();
    });

    // Delete selected
    $('#deleteSelectedBtn').click(function() {
        const ids = $('.row-checkbox:checked').map(function(){ return $(this).val(); }).get();
        if(!ids.length) return Swal.fire('No items selected','Please select items','info');
        Swal.fire({
            title: 'Are you sure?',
            text: `Deleting ${ids.length} item(s)`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!'
        }).then((res) => {
            if(res.isConfirmed){
                $.post('{{ route("item.deleteSelected") }}', {_token:'{{ csrf_token() }}', ids: ids})
                 .done(r => Swal.fire('Deleted!', r.message, 'success').then(()=> location.reload()))
                 .fail(()=> Swal.fire('Error','Failed to delete','error'));
            }
        });
    });

    // Export selected
    $('#exportSelectedBtn').click(function() {
        const ids = $('.row-checkbox:checked').map(function(){ return $(this).val(); }).get();
        if(!ids.length) return Swal.fire('No items selected','Please select items','info');
        const form = $('<form>', {method:'POST', action:'{{ route("item.export") }}', target:'_blank'});
        ids.forEach(id => form.append(`<input type="hidden" name="ids[]" value="${id}">`));
        form.append(`<input type="hidden" name="_token" value="{{ csrf_token() }}">`);
        $('body').append(form); form.submit(); form.remove();
    });

    // Search box
    $('#itemsearchbox').on('keyup', function(){
        const val = $(this).val().toLowerCase();
        $('table tbody tr').filter(function(){ $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1) });
    });

});
</script>
@endsection
