@php
    $searchValue = request()->query('search');
@endphp


{{-- <div class="add-search">
    <div class="center">
        <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
            value="{{ $searchValue ? $searchValue : '' }}">
    </div>
</div>

<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Company Type Permissions</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Company Type Name</th>
                <th>Permissions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
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


@include('admin_setup.permission.company_type_permission.assign')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/permission/company_type_permission.js') }}"></script>