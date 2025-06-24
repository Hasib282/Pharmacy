@php
    $searchValue = request()->query('search');
    $searchMethod = request()->query('method');
    $searchType = request()->query('type');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            @if(Request::segment(1) == 'transaction' && auth()->user()->hasPermission(14))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'hotel' && auth()->user()->hasPermission(308))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'inventory' && auth()->user()->hasPermission(211))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'pharmacy' && auth()->user()->hasPermission(119))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif
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


@include('admin_setup.tran_groupe.add')

@include('admin_setup.tran_groupe.edit')

@include('common_modals.delete')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/tran_groupe.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>