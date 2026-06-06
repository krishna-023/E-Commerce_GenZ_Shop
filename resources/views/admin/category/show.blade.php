@extends('admin.layouts.master')
@section('title') @lang('Category Details') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Category @endslot
        @slot('title') Category Details @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Category Details</h4>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line align-middle me-1"></i> Back to Categories
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Category Info -->
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category Name:</th>
                                        <td>{{ $category->Category_Name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Reference ID:</th>
                                        <td>{{ $category->reference_id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Parent Category:</th>
                                        <td>
                                            @if($category->parent)
                                                {{ $category->parent->Category_Name }}
                                            @else
                                                <span class="text-muted">None (Root Category)</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At:</th>
                                        <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Child Categories -->
                        <div class="col-md-6">
                            <h5>Child Categories:</h5>

                            @php
                                // Recursive function to display child categories
                                function displayChildren($children, $level = 0) {
                                    foreach ($children as $child) {
                                        echo '<div class="list-group-item d-flex justify-content-between align-items-center" style="padding-left: ' . (20 + ($level * 20)) . 'px;">';
                                        echo '<div><i class="ri-arrow-right-line text-muted me-2"></i>' . $child->Category_Name . '</div>';
                                        echo '<span class="badge bg-secondary rounded-pill">' . ($child->reference_id ?? 'N/A') . '</span>';
                                        echo '</div>';

                                        if($child->children->count() > 0){
                                            displayChildren($child->children, $level + 1);
                                        }
                                    }
                                }
                            @endphp

                            @if($category->children->count() > 0)
                                <div class="list-group">
                                    {{ displayChildren($category->children) }}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="ri-information-line me-2"></i> No child categories found.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line align-middle me-1"></i> Edit Category
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="ri-delete-bin-line align-middle me-1"></i> Delete Category
                            </button>
                        </form>
                        <a href="{{ route('categories.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
