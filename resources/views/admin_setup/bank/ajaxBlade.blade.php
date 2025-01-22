@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

<div class="add-search">
    <div class="rows">
        <div class="c-3">
            @if (Auth::user()->user_role == 1)
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            @endif
        </div>
        <div class="c-9 search">
            <select name="searchOption" id="searchOption" class="select-small">
                <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Email</option>
                <option value="3" {{ $searchOptionValue == '3' ? 'selected' : '' }}>Phone</option>
                <option value="4" {{ $searchOptionValue == '4' ? 'selected' : '' }}>Location</option>
                <option value="5" {{ $searchOptionValue == '5' ? 'selected' : '' }}>Address</option>
            </select>
            <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
        </div>
    </div>
</div>


<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">{{ $name }}</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Bank Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Location</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>
    
    <div class="center paginate" id="paginate"> </div>
</div>

@if (Auth::user()->user_role == 1)
    @include('admin_setup.bank.add')

    @include('admin_setup.bank.edit')
@endif

@include('common_modals.detailsModal')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/bank_info.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>

