@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.designations')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add Designation</button>
            {{-- @endif --}}
        </div>
        <div class="c-9 search">
            <select name="searchOption" id="searchOption" class="select-small">
                <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Designation</option>
                <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Department</option>
            </select>
            <input type="text" name="search" id="search" class="input-small" placeholder="Search here..."
                value="{{ $searchValue ? $searchValue : '' }}">
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Designation Details</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('hr.hr_setup.designation.add')

@include('hr.hr_setup.designation.edit')

@include('hr.hr_setup.designation.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/hr/hr_setup/designation.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>