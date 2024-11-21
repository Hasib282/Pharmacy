@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(auth()->user()->hasPermissionToRoute('insert.locations')) --}}
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>
        <div class="c-9 search">
            <select name="searchOption" id="searchOption" class="select-small">
                <option value="1" {{ $searchValue == '1' ? 'selected' : '' }}>Division</option>
                <option value="2" {{ $searchValue == '2' ? 'selected' : '' }}>District</option>
                <option value="3" {{ $searchValue == '3' ? 'selected' : '' }}>Upazila</option>
            </select>
            <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
        </div>
    </div>
</div>

<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">{{ $name }} Details</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Division</th>
                <th>District</th>
                <th>Upazila</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>

@include('admin_setup.location.add')

@include('admin_setup.location.edit')

@include('common_modals.delete')

{{-- ajax part start from here --}}
<script src="{{ asset('js/ajax/admin_setup/location.js') }}"></script>