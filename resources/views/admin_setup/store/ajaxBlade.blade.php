@php
    $searchDivisionValue = request()->query('division');
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.stores')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>
        <div class="c-2">
            <label for="searchDivision">Division</label>
            <select name="searchDivision" id="searchDivision">
                <option value="">All</option>
                <option value="Dhaka" {{ $searchDivisionValue == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                <option value="Mymensingh" {{ $searchDivisionValue == 'Mymensingh' ? 'selected' : '' }}>Mymensingh </option>
                <option value="Sylhet" {{ $searchDivisionValue == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                <option value="Chattogram" {{ $searchDivisionValue == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                <option value="Barishal" {{ $searchDivisionValue == 'Barishal' ? 'selected' : '' }}>Barishal </option>
                <option value="Khulna" {{ $searchDivisionValue == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                <option value="Rajshahi" {{ $searchDivisionValue == 'Rajshahi' ? 'selected' : '' }}>Rajshahi </option>
                <option value="Rangpur" {{ $searchDivisionValue == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
            </select>
        </div>
        <div class="c-2">
            <label for="searchOption">Option</label>
            <select name="searchOption" id="searchOption">
                <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Store Name</option>
                <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Location </option>
            </select>
        </div>
        <div class="c-5">
            <label for="search">Search</label>
            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">{{ $name }}</caption>
        <thead>
            <tr>
                <th>Id</th>
                <th>Store Name</th>
                <th>Division</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('admin_setup.store.add')

@include('admin_setup.store.edit')

@include('common_modals.delete')


{{-- ajax part start from here --}}
<script src="{{ asset('js/ajax/admin_setup/store_info.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>