@php
    $searchValue = request()->query('search');
    $monthValue = request()->query('month');
    $yearValue = request()->query('year');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="center">
            <div class="rows">
                <div class="c-2">
                    <label for="month">Month</label>
                    <select name="month" id="month">
                        <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>January</option>
                        <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>February</option>
                        <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>March</option>
                        <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>May</option>
                        <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>June</option>
                        <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>July</option>
                        <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>August</option>
                        <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <div class="c-2">
                    <label for="year">Year</label>
                    <select name="year" id="year">
                        @for ($year = date('Y'); $year >= 2000; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="c-6">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" class="form-input" placeholder="Search Employee here..." value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;margin: 0;">
                </div>
                <div class="c-2 center">
                    <a class="btn-blue" id="print"><i class="fa-solid fa-print"></i> Print</a>
                </div>
            </div>
            
        </div>
    </div>

    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Salary Details Report</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Id</th>
                    <th>Employee Name</th>
                    <th>Payroll Category</th>
                    <th>Amount</th>
                    <th>Date</th>
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
    <script src="{{ asset('js/ajax/hr/report/salary_details_report.js') }}"></script>
@endsection