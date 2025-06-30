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
                @if(auth()->user()->hasPermission(399))
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
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Net Total</th>
                    <th>Advance</th>
                    <th>Due Col</th>
                    <th>Due Discount</th>
                    <th>Due</th>
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
               @if(Request::segment(1) == 'hospital' && Request::segment(3) == 'admision'   && auth()->user()->hasPermission(398))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif      

                @if(Request::segment(1) == 'hospital' && Request::segment(3) == 'deposit'   && auth()->user()->hasPermission(402))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'hospital' && Request::segment(3) == 'depositrefund'   && auth()->user()->hasPermission(406))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                @endif

                @if(Request::segment(1) == 'hospital' && Request::segment(3) == 'services'   && auth()->user()->hasPermission(410))
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


    @include('transaction.hospital.add')

    @include('transaction.hospital.edit')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/common_ajax/common_transaction_calculations.js') }}"></script>
    <script src="{{ asset('js/ajax').'/' . $js . '.js' }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
