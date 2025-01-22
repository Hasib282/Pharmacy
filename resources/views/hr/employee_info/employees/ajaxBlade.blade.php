@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


<div class="add-search">
    <div class="center">
        <select name="searchOption" id="searchOption" class="select-small">
            <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Name</option>
            <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Email</option>
            <option value="3" {{ $searchOptionValue=='3' ? 'selected' : '' }}>Phone</option>
            <option value="4" {{ $searchOptionValue=='4' ? 'selected' : '' }}>Location</option>
            <option value="5" {{ $searchOptionValue=='5' ? 'selected' : '' }}>Address</option>
            <option value="6" {{ $searchOptionValue=='6' ? 'selected' : '' }}>Nid</option>
            <option value="7" {{ $searchOptionValue=='7' ? 'selected' : '' }}>Dob</option>
            <option value="8" {{ $searchOptionValue=='8' ? 'selected' : '' }}>Employee Type</option>
        </select>
        <input type="text" name="search" id="search" class="input-small" placeholder="Search here..."
            value="{{ $searchValue ? $searchValue : '' }}">
    </div>
</div>

<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Employee Details</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Id</th>
                <th>Name</th>
                <th>Employee Type</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('common_modals.detailsModal')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/hr/employee_info/all_employee.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>