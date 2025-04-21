@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Floor</option>
                  
                </select>
                <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }}</caption>
            <thead>
                <tr>
                    <th>SL:</th>                    
                    <th>Name</th>
                    <th>Floor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"> </div>
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


    
    @include('admin_setup.hospital.nursing_station.add')

    @include('admin_setup.hospital.nursing_station.edit')
    
    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hospital/setup/nursing_station.js') }}"></script>
@endsection
