@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                 @if(auth()->user()->hasPermission(109))
                    <button id="PayrollProcess" data-modal-id="confirmModal"><i class="fa-solid fa-rotate"></i> Process Payroll</button>
                @endif
            </div>
            <div class="c-1">
                <label for="month">Month</label>
                <input type="text" name="month" class="form-input" id="month" data-id="{{ date('m') }}" value="{{ date('F') }}" readonly>
            </div>
            <div class="c-1">
                <label for="year">Year</label>
                <input type="text" name="year" class="form-input" id="year" value="{{ date('Y') }}"
                        readonly>
            </div>
            <div class="c-6">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search Employee here..." value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;margin: 0;">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Payroll / Salary Payment</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Total Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payroll as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item['emp_id'] }}</td>
                        <td>{{ $item['emp_name'] }}</td>
                        <td>{{ number_format($item['salary'], 0, '.', ',') }}</td>
                        <td>
                            @if(Auth::user()->hasPermissionToRoute('insert.payrollMiddlewire'))
                                <button class="open-modal" data-modal-id="detailsModal" id="details"
                                        data-id="{{ $item['emp_id'] }}"><i class="fa-solid fa-circle-info"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>        
    </div> --}}


    {{-- Add Button And Search Fields --}}
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.payroll')) --}}
                    <button id="PayrollProcess" data-modal-id="confirmModal"><i class="fa-solid fa-rotate"></i> Process Payroll</button>
                {{-- @endif --}}
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


    @include('hr.payroll.payroll_installment.editPayroll')

    @include('hr.payroll.payroll_installment.process')


    <!-- ajax part start from here -->
    {{-- <script>
        const urls = {
            insert:         "{{ route('insert.payroll') }}",
            payrollByDate: "{{ route('get.payrollByDate') }}",
            middleware:     "{{ route('insert.payrollMiddlewire') }}",
            search:         "{{ route('search.payroll') }}",
        };
    </script> --}}
    <script src="{{ asset('js/ajax/hr/payroll/payroll.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection