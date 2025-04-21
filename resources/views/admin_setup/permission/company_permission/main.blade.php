@php
    $searchValue = request()->query('search');
    $searchRole = request()->query('role');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows center">
            <div class="c-3">
                <label for="type">Select Type</label>
                <select name="type" id="type">
                    
                </select>
            </div>
            <div class="c-5">
                <div class="form-input-group">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;">
                </div>
            </div>
            <div class="c-4">
                <button class="open-modal" data-modal-id="copyPermission" id="permissionCopy"><i class="fas fa-edit"></i> Assign Permission To Another Company</button>
            </div>
        </div>
    </div>

    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Company Permissions</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Company Id</th>
                    <th>Company Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
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


    @include('admin_setup.permission.company_permission.assign')

    @include('admin_setup.permission.company_permission.copy')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/admin_setup/permission/company_permission.js') }}"></script>
    <script src="{{ asset('js/ajax/admin_setup/permission/copy_company_permission.js') }}"></script>
@endsection
