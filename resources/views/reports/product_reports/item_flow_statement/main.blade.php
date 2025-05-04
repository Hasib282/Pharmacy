@php
    $searchValue = request()->query('search');
    $searchIdValue = request()->query('search_id');
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
                <div class="c-6">
                    <div id="groupein" style="display: none"></div>
                    <label for="product-search">Search Here</label>
                    <input type="text" name="search" id="product-search" class="form-input" placeholder="Search Product here..."
                        value="{{ $searchValue ? $searchValue : '' }}" data-id="{{ $searchIdValue ? $searchIdValue : '' }}" autocomplete="off" style="width: 100%; margin: 0;">
                    <div id="product-search-list">
                        <ul>
    
                        </ul>
                    </div>
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
                    <th>Status</th>
                    <th>Receive</th>
                    <th>Issue</th>
                    <th>Supplier Return</th>
                    <th>Client Return</th>
                    <th>Balance</th>
                    <th>Tran Id</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
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
