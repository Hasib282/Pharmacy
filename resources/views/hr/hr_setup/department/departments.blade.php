@php
    $searchValue = request()->query('search');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.departments')) --}}
                    <button class="open-modal add" data-modal-id="addModal">Add Department</button>
                {{-- @endif --}}
            </div>
            <div class="c-9 search">
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Department Details</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Department Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div>


    @include('hr.hr_setup.department.add')

    @include('hr.hr_setup.department.edit')

    @include('hr.hr_setup.department.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hr/hr_setup/department.js') }}"></script>
@endsection
