@php
    $searchValue = request()->query('search');
    $searchHead = request()->query('searchHead');
@endphp


<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.permissions')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>
        <div class="c-2">
            <label for="searchHead">Main Head</label>
            <select name="searchHead" id="searchHead">
                {{-- options will be display dynamically --}}
            </select>
        </div>
        <div class="c-7">
            <div class="form-input-group">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}">
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
</div>


@include('admin_setup.auth.permission.permissions.add')

@include('admin_setup.auth.permission.permissions.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/auth/permission/permission_heads.js') }}"></script>