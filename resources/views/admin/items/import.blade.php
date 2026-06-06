@extends('admin.layouts.master')

@section('title') Import Items @endsection

@section('content')
    <div class="container mt-5">
        <h2>Import Items</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form action="{{ route('item.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Upload Excel File:</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import Items</button>
        </form>
    </div>
@endsection
