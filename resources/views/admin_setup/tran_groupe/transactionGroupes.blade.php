@php
    $searchValue = request()->query('search');
    $searchMethod = request()->query('method');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.tranGroupes')) --}}
                <button class="open-modal add" data-modal-id="addModal">Add {{ $name }}</button>
                {{-- @endif --}}
            </div>
            <div class="c-2">
                <label for="types">Groupe Type</label>
                <select name="types" id="types">
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="methods">Method</label>
                <select name="methods" id="methods">
                    <option value="">Select Method</option>
                    <option value="Receive" {{ $searchMethod == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment" {{ $searchMethod == 'Payment' ? 'selected' : '' }}>Payment</option>
                    <option value="Both" {{ $searchMethod == 'Both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
            <div class="c-5">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
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
                    <th>{{ $name }} Name</th>
                    <th>{{ $name }} Type</th>
                    <th>Transaction Method</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div>


    @include('admin_setup.tran_groupe.add')

    @include('admin_setup.tran_groupe.edit')

    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/admin_setup/tran_groupe.js') }}"></script>
@endsection
