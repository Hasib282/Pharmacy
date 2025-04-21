@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    {{-- <div class="add-search">
        <div class="rows">
            <div class="c-3">
                @if(Auth::user()->hasPermissionToRoute('insert.admins'))
                    <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                @endif
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Email</option>
                    <option value="3" {{ $searchOptionValue == '3' ? 'selected' : '' }}>Phone</option>
                    @if ($name != "Super Admin" && $name != "Admin")
                        <option value="4" {{ $searchOptionValue == '4' ? 'selected' : '' }}>Location</option>
                        <option value="5" {{ $searchOptionValue == '5' ? 'selected' : '' }}>Address</option>
                        <option value="6" {{ $searchOptionValue == '6' ? 'selected' : '' }}>Type</option>
                    @endif
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
                    <th>{{ $name }} Id</th>
                    <th>Name</th>

                    @if ($name != "Admin" && $name != "Super Admin")
                        <th>{{ $name }} Type</th>
                    @endif

                    <th>Email</th>
                    <th>Phone</th>
                    
                    @if ($name != "Super Admin" && $name != "Admin")
                        <th>Location</th>
                        <th>Address</th>
                    @endif

                    <th>Image</th>
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


    @include('users.add')

    @include('users.edit')

    @include('common_modals.detailsModal')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/users/' . $js . '.js') }}"></script>
    {{-- <script src="{{ asset('js/ajax/admin_setup/users').'/' . $js . '.js' }}"></script> --}}
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
