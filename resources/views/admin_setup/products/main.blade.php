@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                @if(Auth::user()->hasPermissionToRoute('insert.pharmacyProduct'))
                    <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                @endif
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1">Head</option>
                    <option value="2">Groupe</option>
                    <option value="3">Category</option>
                    <option value="4">Manufacture</option>
                    <option value="5">Item Form</option>
                    <option value="6">Unit</option>
                    <option value="7">Expired Date</option>
                </select>
                <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
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
                    <th>Product Name</th>
                    <th>Transaction Groupe</th>
                    <th>Category Name</th>
                    <th>Manufacturer</th>
                    <th>Item Form Name</th>
                    <th>QTY</th>
                    <th>Unite</th>
                    <th>CP</th>
                    <th>MRP</th>
                    <th>Expiry</th>
                    @if ( UserRole() == 1 )
                        <th style="width:12%;">Company Id</th>
                    @endif
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


    @include('admin_setup.products.add')

    @include('admin_setup.products.edit')

    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax').'/'. $js .'.js' }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
