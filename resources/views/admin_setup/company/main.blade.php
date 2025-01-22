@php
    $searchType = request()->query('type');
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-2">
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
            </div>
            <div class="c-2">
                <label for="companyType">Select Type</label>
                <select name="companyType" id="companyType">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Email</option>
                    <option value="3" {{ $searchOptionValue == '3' ? 'selected' : '' }}>Phone</option>
                    <option value="4" {{ $searchOptionValue == '4' ? 'selected' : '' }}>Address</option>
                </select>
            </div>
            <div class="c-6">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%;">
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
                    <th>Id</th>
                    <th>Name</th>
                    <th>Company Type</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div>


    @include('admin_setup.company.add')

    @include('admin_setup.company.edit')

    @include('common_modals.detailsModal')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/admin_setup/').'/' . $js . '.js' }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
