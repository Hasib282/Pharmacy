@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
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
                    <th>Pid</th>
                    <th>Rid</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Action</th>
                    <th>Age(Y,M,D)</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Religion</th>
                    <th>Doctor</th>
                    <th>Sells_representative(SR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"> </div>
    </div>


    
    @include('admin_setup.hospital.patient_registration.add')

    @include('admin_setup.hospital.patient_registration.edit')
    
    @include('common_modals.delete')

    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/hospital/setup/patient_registration.js') }}"></script>
@endsection
