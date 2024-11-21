@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.payrollSetup')) --}}
                    <button class="open-modal add" data-modal-id="addModal">Add Payroll Setup</button>
                {{-- @endif --}}
            </div>
            <div class="c-9 search">
                <select name="searchOption" id="searchOption" class="select-small">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>User Name</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Head</option>
                </select>
                <input type="text" name="search" id="search" class="input-small" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Additional Payroll Details</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Payroll Category</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @php
                    $lastEmpId = null;
                @endphp
                
                @foreach ($payroll as $key => $item)
                    <tr>
                        <td>{{ $payroll->firstItem() + $key }}</td>
                        
                        @if($item->emp_id != $lastEmpId)
                            <td>{{ $item->emp_id }}</td>
                            <td>{{ $item->Employee->user_name }}</td>
        
                            @php
                                $lastEmpId = $item->emp_id;
                            @endphp
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        
                        
        
                        <td>{{ $item->Head->tran_head_name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>
                            <div style="display: flex;gap:5px;">
                                @if(Auth::user()->hasPermissionToRoute('update.payrollSetup'))
                                    <button class="open-modal" data-modal-id="editModal" id="edit"
                                        data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->hasPermissionToRoute('delete.payrollSetup'))
                                    <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>        
    </div>


    @include('hr.payroll.payroll_setup.add')

    @include('hr.payroll.payroll_setup.edit')

    @include('hr.payroll.payroll_setup.delete')


    <!-- ajax part start from here -->
    {{-- <script>
        const urls = {
            insert:     "{{ route('insert.payrollSetup') }}",
            edit:       "{{ route('edit.payrollSetup') }}",
            update:     "{{ route('update.payrollSetup') }}",
            delete:     "{{ route('delete.payrollSetup') }}",
            search:     "{{ route('search.payrollSetup') }}",
            paginate:   "{{ route('pagination.payrollSetup') }}",
            getuser:    "{{ route('get.payrollUser') }}",
        };
    </script> --}}
    <script src="{{ asset('js/ajax/hr/payroll/payroll_setup.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
