@php
    $searchValue = request()->query('search');
    $searchHead = request()->query('searchHead');
@endphp


{{-- <div class="add-search">
    <div class="rows">
        <div class="c-3">
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
        </div>
        <div class="c-2">
            <div class="form-input-group">
                <label for="searchHead">Main Head</label>
                <select name="searchHead" id="searchHead">
                    options will be display dynamically
                </select>
            </div>
        </div>
        <div class="c-7">
            <div class="form-input-group">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;margin:0;">
            </div>

        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Permission Details</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Main Head</th>
                <th>Permission Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div> --}}


{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
        </div>
        <div class="c-6">

        </div>
        <div class="c-3" style="padding: 0;">
            <input type="text" id="globalSearch" placeholder="Search..." />
        </div>
    </div>
</div>

{{-- Datatable Part --}}
<div class="load-data">
    <table class="data-table" id="data-table">
        <caption>{{ $name }} Details</caption>
        <thead></thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div id="paginate"></div>
</div>


@include('admin_setup.permission.permissions.add')

@include('admin_setup.permission.permissions.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/permission/permission_heads.js') }}"></script>