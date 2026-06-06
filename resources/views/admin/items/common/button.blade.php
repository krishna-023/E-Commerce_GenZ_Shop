<div class="col-lg-auto">
    <div class="hstack flex-wrap gap-2">

        <a href="{{ route('item.add') }}" class="btn btn-secondary btn-sm"><i class="bi bi-plus-circle align-baseline me-1"></i> Add Item</a>
        <div>
            <a href="" class="btn btn-subtle-primary btn-sm"><i class="bi bi-grid"></i></a>
            <a href="{{ route('item.index') }}" class="btn btn-subtle-primary active btn-sm"><i class="bi bi-list-task"></i></a>
        </div>
        <button type="button" id="deleteSelectedBtn" class="btn btn-danger btn-sm" style="display: none;">Delete Selected</button>
        <button type="button" id="exportSelectedBtn" class="btn btn-secondary btn-sm">
        <i class="bi bi-download align-baseline me-1"></i> Export Selected</button>
    </div>
</div>
