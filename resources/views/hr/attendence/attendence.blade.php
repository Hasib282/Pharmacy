@php
    $searchValue = request()->query('search');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.payrollMiddlewire')) --}}
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                {{-- @endif --}}
            </div>
            <div class="c-2">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-input"
                    value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-2">
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-input"
                    value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-5">
                <label for="search">Search Here</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }} Details</caption>
            <thead>
                <tr>
                    <th style="width:4%;">SL:</th>
                    <th style="width:8%;">Employee Id</th>
                    <th style="width:25%;">Employee Name</th>
                    <th style="width:8%;">Date</th>
                    <th style="width:5%;">In</th>
                    <th style="width:5%;">Out</th>
                    <th style="width:5%;">Working Hours</th>
                    <th style="width:15%;">Insert At</th>
                    <th style="width:15%;">Update At</th>
                    <th style="width:10%;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>        
    </div>


    @include('hr.attendence.add')

    @include('hr.attendence.edit')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hr/attendence.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
