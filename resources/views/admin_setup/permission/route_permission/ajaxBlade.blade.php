@php
    $searchValue = request()->query('search');
@endphp


<div class="add-search">
    <div class="center">
        <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
            value="{{ $searchValue ? $searchValue : '' }}">
    </div>
</div>

<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Route Permissions</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Permissions</th>
                <th>Route Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>

@include('admin_setup.permission.route_permission.assign')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/permission/route_permission.js') }}"></script>