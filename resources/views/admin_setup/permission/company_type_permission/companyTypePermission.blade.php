@php
    $searchValue = request()->query('search');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="center">
            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
        </div>
    </div>

    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Company Type Permissions</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Company Type Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
    </div>

    @include('admin_setup.permission.company_type_permission.assign')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/admin_setup/permission/company_type_permission.js') }}"></script>
@endsection
