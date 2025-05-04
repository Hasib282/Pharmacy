@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="center">
            <div class="rows">
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
                        <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Transaction Id</option>
                        <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>User</option>
                        <option value="3" {{ $searchOptionValue=='3' ? 'selected' : '' }}>Product Name</option>
                    </select>
                </div>
                <div class="c-4">
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
                    <th>Id</th>
                    <th>User</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Cost Price</th>
                    <th>Total Cost Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Transaction Date</th>
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
            <div class="c-3"></div>
            <div class="c-3">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-3" >
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-input" value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-1"></div>
            <div class="c-1">
                <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
            </div>
            <div class="c-1"></div>
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