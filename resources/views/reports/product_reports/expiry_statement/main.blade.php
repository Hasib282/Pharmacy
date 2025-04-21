@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $startDateValue = request()->query('startDate');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="center">
            <div class="rows">
                <div class="c-2">
                    <label for="startDate">Select Date</label>
                    <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
                </div>
                <div class="c-2">
                    <label for="searchOption">Search Option</label>
                    <select name="searchOption" id="searchOption">
                        <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Product Name</option>
                        <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Batch Id</option>
                    </select>
                </div>
                <div class="c-6">
                    <label for="search">Search Here</label>
                    <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                        value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
                </div>
                <div class="c-2">
                    <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>

    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }} Statement</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Product Name</th>
                    <th>Expiry Date</th>
                    <th>Batch Id</th>
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
                    <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
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


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>
@endsection
