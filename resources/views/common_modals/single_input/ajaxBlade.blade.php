@php
    $searchValue = request()->query('search');
@endphp


<div class="add-search">
    <div class="rows">
        <div class="c-3">
            {{-- @if(Auth::user()->hasPermissionToRoute('insert.roles')) --}}
            <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            {{-- @endif --}}
        </div>
        <div class="c-9 search">
            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
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
                <th>{{ $name }} Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>


@include('common_modals.single_input.add')

@include('common_modals.single_input.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
<script src="{{ asset('js/ajax/common_ajax/single_input.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>