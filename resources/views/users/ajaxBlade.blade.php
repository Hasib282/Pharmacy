@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

{{-- Add Button And Search Fields --}}
<div class="add-search">
    <div class="rows">
        <div class="c-3">
            @if(Request::segment(1) == 'admin'  && auth()->user()->hasPermission(2))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif
            @if(Request::segment(1) == 'transaction' && Request::segment(3) == 'clients'   && auth()->user()->hasPermission(26))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'transaction' && Request::segment(3) == 'suppliers'   && auth()->user()->hasPermission(30))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif


            @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'clients'   && auth()->user()->hasPermission(223))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'suppliers'   && auth()->user()->hasPermission(227))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif


            
            @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'clients'   && auth()->user()->hasPermission(141))
                <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
            @endif

            @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'suppliers'   && auth()->user()->hasPermission(145))
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


@include('users.add')

@include('users.edit')

@include('common_modals.detailsModal')

@include('common_modals.delete')

@include('common_modals.deleteStatus')


<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/users/' . $js . '.js') }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>