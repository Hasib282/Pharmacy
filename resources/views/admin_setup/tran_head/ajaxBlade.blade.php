@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp


<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.tranHeads')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>
        <div class="c-9 search">
            <select name="searchOption" id="searchOption" class="select-small">
                <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Head</option>
                <option value="2" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Groupe</option>
            </select>
            <input type="text" name="search" id="search" class="input-small" placeholder="Search here..."
                value="{{ $searchValue ? $searchValue : '' }}">
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
                <th>Transaction Head Name</th>
                <th>Transaction Groupe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('admin_setup.tran_head.add')

@include('admin_setup.tran_head.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/admin_setup/tran_head.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>