@php
    $searchValue = request()->query('search');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                @if(Auth::user()->hasPermissionToRoute('insert.roles'))
                    <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                @endif
            </div>
            <div class="c-9 search">
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }} Details</caption>
            <thead>
                <tr>
                    <th style="width:4%;">SL:</th>
                    <th>{{ $name }} Name</th>
                    @if ( UserRole() == 1 && (Request::segment(1) == 'pharmacy' || Request::segment(1) == 'inventory') )
                        <th style="width:12%;">Company Id</th>
                    @endif
                    <th style="width:12%;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div> --}}


    {{-- Add Button And Search Fields --}}
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                @if((Request::segment(2) == 'companytype' || Request::segment(3) == 'roles' || Request::segment(3) == 'mainhead') && Auth::user()->user_role == 1)
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
                @if(Request::segment(2) == 'payment_method' && auth()->user()->hasPermission(288))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
                @if(Request::segment(1) == 'hr' && Request::segment(3) == 'departments' && auth()->user()->hasPermission(58))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
                {{-- pharmacy --}}
                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'manufacturer'   && auth()->user()->hasPermission(113))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'category'   && auth()->user()->hasPermission(117))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'unit'   && auth()->user()->hasPermission(121))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'form'   && auth()->user()->hasPermission(125))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif


                {{-- inventory --}}
                @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'manufacturer'   && auth()->user()->hasPermission(195))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'category'   && auth()->user()->hasPermission(199))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'unit'   && auth()->user()->hasPermission(203))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'form'   && auth()->user()->hasPermission(207))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                    {{-- hotel --}}
                @if(Request::segment(1) == 'hotel' && Request::segment(3) == 'roomcatagory'   && auth()->user()->hasPermission(300))
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


    @include('common_modals.single_input.add')

    @include('common_modals.single_input.edit')

    @include('common_modals.delete')

    @include('common_modals.deleteStatus')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
    <script src="{{ asset('js/ajax/common_ajax/single_input.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
