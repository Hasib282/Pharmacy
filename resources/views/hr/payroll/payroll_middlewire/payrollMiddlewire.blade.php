@section('style')
    <style>
        #search {
            width: 100%;
            margin: 0;
        }
        #searchOption {
            width: 100%;
            margin: 0;
        }
    </style>
@endsection

@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
@endphp

@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-3">
                {{-- @if(Auth::user()->hasPermissionToRoute('insert.payrollMiddlewire')) --}}
                    <button class="open-modal add" data-modal-id="addModal">Add Payroll Middlewire</button>
                {{-- @endif --}}
            </div>
            <div class="c-2">
                <label for="optionMonth">Month</label>
                <select name="month" id="optionMonth">
                    <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>January</option>
                    <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>February</option>
                    <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>March</option>
                    <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>May</option>
                    <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>June</option>
                    <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>July</option>
                    <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>August</option>
                    <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>December</option>
                </select>
            </div>
            <div class="c-1">
                <label for="optionYear">Year</label>
                <select name="year" id="optionYear">
                    @for ($year = date('Y'); $year >= 2000; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="c-6">
                <div class="rows">
                    <div class="c-2">
                        <div class="form-group">
                            <label for="searchOption">Search Option</label>
                            <select name="searchOption" id="searchOption">
                                <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>User Name</option>
                                <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Head</option>
                            </select>
                        </div>
                    </div>
                    <div class="c-10">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-input" placeholder="Search here..." value="{{ $searchValue ? $searchValue : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Additional Payroll Middlewire</caption>
            <thead>
                <tr>
                    <th>SL:</th>
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Payroll Category</th>
                    <th>Amount</th>
                    <th>Month</th>
                    <th>Year</th>
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
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        
                        @php
                            $lastEmpId = $item->emp_id;
                        @endphp
        
                        <td>{{ $item->Head->tran_head_name }}</td>
                        <td>{{ $item->amount }}</td>
                        @if ($item->date != null)
                            <td>{{ date('m', strtotime($item->date)) }}</td>
                            <td>{{ date('Y', strtotime($item->date)) }}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        
                        <td>
                            <div style="display: flex;gap:5px;">
                                @if(Auth::user()->hasPermissionToRoute('update.payrollMiddlewire'))
                                    <button class="open-modal" data-modal-id="editModal" id="edit"
                                        data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                @endif
                                @if(Auth::user()->hasPermissionToRoute('delete.payrollMiddlewire'))
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


    @include('hr.payroll.payroll_middlewire.add')

    @include('hr.payroll.payroll_middlewire.edit')

    @include('hr.payroll.payroll_middlewire.delete')


    <!-- ajax part start from here -->
    {{-- <script>
        const urls = {
            insert:     "{{ route('insert.payrollMiddlewire') }}",
            edit:       "{{ route('edit.payrollMiddlewire') }}",
            update:     "{{ route('update.payrollMiddlewire') }}",
            delete:     "{{ route('delete.payrollMiddlewire') }}",
            search:     "{{ route('search.payrollMiddlewire') }}",
            paginate:   "{{ route('pagination.payrollMiddlewire') }}",
            getuser:    "{{ route('get.payrollUser') }}",
        };
    </script> --}}
    <script src="{{ asset('js/ajax/hr/payroll/payroll_middlewire.js') }}"></script>
    <script src="{{ asset('js/ajax/search_by_input.js') }}"></script>
@endsection
