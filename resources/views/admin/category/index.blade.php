@extends('admin.layouts.master')
@include('common.flash')
@section('title') @lang('Categories') @endsection

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .table-hierarchy tbody tr td:first-child {
        padding-left: 20px;
    }
    .table-hierarchy .child-row td:first-child {
        padding-left: 40px;
    }
    .action-buttons .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Category @endslot
    @slot('title') Manage Categories @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Categories</h4>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="ri-add-line align-middle me-1"></i> Add Category
                </a>
            </div>
            <div class="card-body">
                @include('common.flash')

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-hierarchy">
                        <thead>
                            <tr>
                                <th width="40%">Category Name</th>
                                <th width="15%">Reference ID</th>
                                <th width="15%">Parent</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($categories->count())
                                @php
                                    function renderCategory($category, $level = 0) {
                                        $padding = 20 + ($level * 20);
                                        echo '<tr class="'.($level > 0 ? 'child-row' : '').'">';
                                        echo '<td style="padding-left: '.$padding.'px;">';
                                        if($level > 0) echo '<i class="ri-arrow-right-s-line text-muted me-1"></i>';
                                        echo e($category->Category_Name);
                                        echo '</td>';
                                        echo '<td><span class="text-muted">'.($category->reference_id ?? 'N/A').'</span></td>';
                                        echo '<td><span class="text-muted">'.($category->parent?->Category_Name ?? '-').'</span></td>';
                                        echo '<td class="action-buttons">
                                            <a href="'.route('categories.show', $category->id).'" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="'.route('categories.edit', $category->id).'" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <form action="'.route('categories.destroy', $category->id).'" method="POST" class="d-inline">
                                                '.csrf_field().method_field('DELETE').'
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </td>';
                                        echo '</tr>';

                                        if($category->children->count()) {
                                            foreach($category->children as $child) {
                                                renderCategory($child, $level + 1);
                                            }
                                        }
                                    }
                                @endphp

                                @foreach($categories as $category)
                                    @php renderCategory($category) @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ri-folder-open-line text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-2">No categories found. Create your first category!</p>
                                            <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2">
                                                <i class="ri-add-line align-middle me-1"></i> Add Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection
