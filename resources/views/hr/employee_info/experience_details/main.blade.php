@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                  @if(auth()->user()->hasPermission(86))
                        <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                    @endif
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1" {{ $searchOptionValue=='1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue=='2' ? 'selected' : '' }}>Email</option>
                    <option value="3" {{ $searchOptionValue=='3' ? 'selected' : '' }}>Phone</option>
                    <option value="4" {{ $searchOptionValue=='4' ? 'selected' : '' }}>Location</option>
                    <option value="5" {{ $searchOptionValue=='5' ? 'selected' : '' }}>Address</option>
                    <option value="6" {{ $searchOptionValue=='6' ? 'selected' : '' }}>Nid</option>
                    <option value="7" {{ $searchOptionValue=='7' ? 'selected' : '' }}>Dob</option>
                    <option value="8" {{ $searchOptionValue=='8' ? 'selected' : '' }}>Employee Type</option>
                </select>
                <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>

    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Employee Experience Details</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Image</th>
                    <th>Status</th>
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
                       @if(auth()->user()->hasPermission(86))
                            <button class="open-modal" data-modal-id="addModal" id="add"><i class="fa-solid fa-plus"></i> Add {{ $name }} </button>
                        @endif
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


    @include('hr.employee_info.experience_details.add')

    @include('common_modals.detailsModal')

    @include('hr.employee_info.experience_details.edit')

    @include('common_modals.delete')

    @include('common_modals.deleteStatus')
    
    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hr/employee_info/employeeExperience.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
