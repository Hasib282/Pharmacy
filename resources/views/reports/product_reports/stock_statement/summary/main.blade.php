@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Product Name</option>
                    <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Groupe</option>
                    <option value="3" {{ $searchOptionValue=='3' ? 'selected' : '' }}>Category</option>
                    <option value="4" {{ $searchOptionValue=='4' ? 'selected' : '' }}>Manufacture</option>
                    <option value="5" {{ $searchOptionValue=='5' ? 'selected' : '' }}>Item Form</option>
                </select>
            </div>
            <div class="c-9">
                <label for="search">Search Here</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
            <div class="c-1">
                <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
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
                    <th>Transaction Groupe</th>
                    <th>Category Name</th>
                    <th>Manufacturer</th>
                    <th>Item Form</th>
                    <th>QTY</th>
                    <th>Unit</th>
                    <th>CP</th>
                    <th>MRP</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>        
    </div>

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>
@endsection
