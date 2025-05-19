@php
    $searchDivisionValue = request()->query('division');
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-2">
                @if(Auth::user()->hasPermissionToRoute('insert.stores'))
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                @endif
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Bed Catagory </option>
                    <option value="3" {{ $searchOptionValue == '3' ? 'selected' : '' }}>Nursing Station </option>
                </select>
            </div>
            <div class="c-8">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
        </div>
    </div>
    
    
    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">{{ $name }}</caption>
            <thead>
                <tr>
                    <th>Id</th>
                    <th> Name</th>
                    <th>Bed Catagory</th>
                    <th>Nursing Station</th>
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
                  {{--  <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>--}}
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


    @include('admin_setup.hotel.setup.room_catagory.add')

    @include('admin_setup.hotel.setup.room_catagory.edit')

    @include('common_modals.delete')

    
   {{-- ajax part start from here --}}
<script src="{{ asset('js/ajax').'/'. $js . '.js' }}"></script>
<script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection