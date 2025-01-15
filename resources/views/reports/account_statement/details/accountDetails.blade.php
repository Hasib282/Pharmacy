@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $searchTypeValue = request()->query('type');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp


@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
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
                <label for="typeOption">Transaction Type</label>
                <select name="typeOption" id="typeOption">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Groupe</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Product / Service</option>
                </select>
            </div>
            <div class="c-3">
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
            <caption class="caption">Accounts Details Statement</caption>
            <thead>
                <tr>
                    <th style="text-align: right;">Opening Balance</th>
                    <th></th>
                    <th style="text-align: right; width:14%;" id="opening"></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right;">Grand Total:</td>
                    <td style="text-align: right; width:14%;" id="grandReceive"></td>
                    <td style="text-align: right; width:14%;" id="grandPayment"></td>
                </tr>
                <tr>
                    <td style="text-align: right;">Closing Balance</td>
                    <td></td>
                    <td style="text-align: right; width:14%;" id="closing"></td>
                </tr>
            </tfoot>
        </table>
    </div>


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/report/account_statement/details.js') }}"></script>
@endsection