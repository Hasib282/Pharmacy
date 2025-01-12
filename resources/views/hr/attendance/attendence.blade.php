@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-12">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.payrollMiddlewire')) --}}
                    <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                {{-- @endif --}}
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
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Payroll Category</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>        
    </div>


    @include('hr.payroll.payroll_middlewire.add')

    @include('hr.payroll.payroll_middlewire.edit')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hr/payroll/payroll_middlewire.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
