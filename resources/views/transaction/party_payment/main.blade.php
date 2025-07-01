@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                 @if(auth()->user()->hasPermission(42))
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
            </div>
            <div class="c-2">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-2" >
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-input" value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Transaction Id</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="c-3">
                <label for="search">Search Here</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
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
                    <th>Id</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div> --}}

    
    {{-- Add Button And Search Fields --}}
    <div class="add-search">
        <div class="rows" style="align-items:center;">
            <div class="c-3">
                @if(Request::segment(1) == 'transaction' && Request::segment(3) == 'receive'   && auth()->user()->hasPermission(42))
                        <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'transaction' && Request::segment(3) == 'payment'   && auth()->user()->hasPermission(46))
                        <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                 @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'receive'   && auth()->user()->hasPermission(256))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'inventory' && Request::segment(3) == 'payment'   && auth()->user()->hasPermission(260))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'receive'   && auth()->user()->hasPermission(174))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'pharmacy' && Request::segment(3) == 'payment'   && auth()->user()->hasPermission(178))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif
            </div>
            <div class="c-3">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-3" >
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-input" value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-3" >
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


    @include('transaction.party_payment.add')

    @include('transaction.party_payment.edit')

    @include('common_modals.delete')

    @include('common_modals.deleteStatus')

    <script src="{{ asset('js/ajax/' . Request::segment(1) . '/party_payment/' . $js . '.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection


