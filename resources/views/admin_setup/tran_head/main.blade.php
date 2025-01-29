@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.tranHeads')) --}}
                    <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                {{-- @endif --}}
            </div>

            <div class="c-9 search">
                @if (Request::segment(1) == 'hr')
                    <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                        value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
                @else
                    <select name="searchOption" id="searchOption" class="select-small">
                        <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Head</option>
                        <option value="2" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Groupe</option>
                    </select>
                    <input type="text" name="search" id="search" class="input-small" placeholder="Search here..."
                        value="{{ $searchValue ? $searchValue : '' }}">
                @endif
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
                    <th>Transaction Head Name</th>
                    @if (Request::segment(1) != 'hr')
                        <th>Transaction Groupe</th>
                    @endif
                    @if (UserRole() == 1)
                        <th style="width:12%;">Company Id</th>
                    @endif
                    <th style="width:12%;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div>


    @include('admin_setup.tran_head.add')

    @include('admin_setup.tran_head.edit')

    @include('common_modals.delete')


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/' . (Request::segment(1) == 'admin' ? 'admin_setup' : Request::segment(1)) . '/tran_head.js') }}"></script>
    {{-- <script src="{{ asset('js/ajax/admin_setup/tran_head.js') }}"></script> --}}
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
