@extends('admin.layouts.master')
@include('common.flash')
@section('title') @lang('Create Category')  @endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Category @endslot
        @slot('title') Create New Category @endslot
    @endcomponent

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Create New Category</h3>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Category_Name">Category Name *</label>
                                        <input type="text" name="Category_Name" id="Category_Name"
                                               class="form-control @error('Category_Name') is-invalid @enderror"
                                               value="{{ old('Category_Name') }}" required>
                                        @error('Category_Name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference_id">Reference ID</label>
                                        <input type="text" name="reference_id" id="reference_id"
                                               class="form-control @error('reference_id') is-invalid @enderror"
                                               value="{{ old('reference_id') }}">
                                        @error('reference_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="parent_id">Parent Category</label>
                                <select name="parent_id" id="parent_id"
                                        class="form-control @error('parent_id') is-invalid @enderror">
                                    <option value="">Select Parent Category (Optional)</option>

                                    @php
                                        $renderOptions = function ($categories, $prefix = '') use (&$renderOptions) {
                                            foreach ($categories as $cat) {
                                                echo '<option value="'.$cat->id.'"'
                                                    .(old('parent_id') == $cat->id ? ' selected' : '').'>'
                                                    .$prefix.' '.$cat->Category_Name
                                                    .'</option>';

                                                if ($cat->children->count() > 0) {
                                                    $renderOptions($cat->children, $prefix.'--');
                                                }
                                            }
                                        };
                                    @endphp

                                    @foreach($parentCategories as $parent)
                                        @php $renderOptions(collect([$parent])); @endphp
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-save"></i> Create Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
